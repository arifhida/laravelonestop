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
        $categories = Category::all();
        $data = Category::with('productshome.images')->get();
        
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
        # code...
    }
}
