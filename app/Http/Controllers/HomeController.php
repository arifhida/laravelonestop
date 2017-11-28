<?php

namespace App\Http\Controllers;

use App\Category as Category;
use App\Product as Product;
use DB;
use Route;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // DB::connection()->enableQueryLog();
        $categories = Category::all();
        $data = Category::all();
        foreach($data as $category){
            $products = Product::with('images','sub_category')->where('category_id','=',$category->id)->orderby('id','desc')->take(5)->get();
            if($products)
                $category['products'] = $products;
        }
        // dd(DB::getQueryLog());
        // return response()->json($data);
        // dd($data);
        return view('home',compact('categories','data'));
    }

    public function product(Request $request,$id)
    {
        $categories = Category::all();
        $keyword = $request['keyword'];
        $query = Product::with('images')->where('category_id','=',$id);
        if($keyword){
            $query->where('product_name','like',"%$keyword%");
        }        
        $data = $query->get();
        return view('home.product',compact('categories','data','id'));        
    }

    public function show($id){
        $data = Product::with('images','category','sub_category')->findOrFail($id);
        return response()->json($data);
    }

}
