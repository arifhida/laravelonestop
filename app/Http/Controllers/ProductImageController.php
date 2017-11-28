<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductImage as ProductImage;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $this->validate($request, [
            'product_id' => 'required',
            'image' => 'required|image|mimes:jpeg,bmp,png|max:2000'   
        ]);
        $path = $request->image->store('public/' . $request->category_id);
        $input['image_url'] = $path;
        $input['image'] = basename($path);
        ProductImage::create($input);
        $id = $request->product_id;
        
        return redirect()->route('product.edit',['product' =>$id]);
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $image = ProductImage::find($id);
        Storage::delete($image->image);
        $image->delete();
        return response()->json(['status'=> 'OK']);
        //
    }
}
