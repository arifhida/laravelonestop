<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\productpost;
use App\Product as Product;
use App\Category as Category;
use App\ProductImage as ProductImage;
use App\SubCategory as SubCategory;

class ProductController extends Controller
{

    public function __construct(){
        $this->middleware('auth')->only('index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Product::with('category')->get();        
        return View('product.index',compact('data'));
        //
    }

    public function data(Request $request){
        $start = $request['start'];
        $length = $request['length'];
        $data = Product::getData($request); 
        $recordsFiltered = $data->get()->count();
        $result = $data->skip($start)->take($length)->get();
        $draw = $request->draw + 1;
        $recordsTotal = Product::all()->count();
        return response()->json(['draw'=> $draw, 'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered, 'data' => $result ]);
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();        
        return View('product.create',compact('categories'));
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(productpost $request)
    {
        
        $input = $request->all();
        unset($input['downloadurl']);
        unset($input['images']);
        $path = $request->downloadurl->store('public/' . $request->category_id);
        $input['url'] = $path;
        $input['active'] = 1;
        $id = Product::create($input)->id;
        if($request->hasFile('images')){
            foreach($request->images as $imageurl){
                $url = $imageurl->store('public');
                $image = array(
                    'product_id'=> $id,
                    'image' => basename($url),
                    'image_url'=> $url
                );

                ProductImage::create($image);
            }
        }
        return redirect('product');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Product::with('category','images')->findOrFail($id);

        return response()->json(['data'=> $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Product::with('category','images')->findOrFail($id);
        foreach($data->images as $image){
            $image->image_url = url('/') . '/storage/'. $image->image;
        }
        $categories = Category::all();
        $subcategories = SubCategory::where('category_id','=',$data->category_id)->get();
        return View('product.edit',compact('data','categories','subcategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $this->validate($request, [
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'product_name' => 'required',
            'description' => 'required',
            'price' => 'required'        
        ]);
        $data = Product::find($id);
        if($request->hasFile('downloadurl')){
            $path = $request->downloadurl->store('public/' . $request->category_id);
            $input['url'] = $path;
        }
        $data->update($input);
        return redirect('product');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return response()->json(['status'=> 'OK']);
        //
    }
}
