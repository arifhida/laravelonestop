<?php

namespace App\Http\Controllers;

use App\Category as Category;

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

    public function product(Request $request)
    {

        # code...
    }
}
