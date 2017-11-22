<?php

namespace App\Http\Controllers;

use App\Category as Category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class CategoryController extends Controller
{
    //


    public function __constructor(){

    }
    public function index(){                      
        return view('category.index');
    }
    public function data(Request $request){
        $start = $request['start'];
        $length = $request['length'];
        $data = Category::getData($request->all());
        $recordsFiltered = $data->get()->count();
        $result = $data->skip($start)->take($length)->get();
        $draw = $request->draw + 1;
        $recordsTotal = Category::all()->count();
        return response()->json(['draw'=> $draw, 'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered, 'data' => $result ]);
    }

    public function create(){       
        
        return View('category.create');
    }

    public function store(Request $request){        
        $this->validate($request,[
            'name' => 'required'
        ]);
        Category::create(['name'=>$request->name,'active'=>$request->active]);
        return response()->json(['status'=> 'OK']);
    }

    public function show($id){
        $category = Category::find($id);
        return response()->json(['category'=> $category]);
    }

    public function edit($id){
        $category = Category::find($id);
        return View('category.edit',['category'=> $category]);
    }

    public function update(Request $request, $id){
        $category = Category::find($id);
        $input = $request->all();

        $category->update($input);
        
        return response()->json(['status'=> 'OK']);

    }

    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        return response()->json(['status'=> 'OK']);
        //
    }

    
}
