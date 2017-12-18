<?php

namespace App\Http\Controllers;

use App\Role as Role;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return View('role.index');
        //
    }

    public function data(Request $request){
        $start = $request['start'];
        $length = $request['length'];
        $data = Role::getData($request->all());
        // dd($data->get());
        $recordsFiltered = $data->get()->count();
        $result = $data->skip($start)->take($length)->get();
        $draw = $request->draw + 1;
        $recordsTotal = Role::all()->count();

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
        //
        $this->validate($request,[
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);
        $input = $request->all();
        // dd($input);
        
        Role::create([
            'name' => $input['name'],
            'description' => $input['description'],
        ]);
        return response()->json(['status' => "OK"]);
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
        $data = Role::find($id);
        return response()->json(['role'=> $data]);
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
        $this->validate($request,[
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);
        // dd($request->password);
        $input = $request->all();
        $data = Role::findOrFail($id);
        $data->update($input);
        return response()->json(['status'=> 'OK']);
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
        $data = Role::findOrFail($id);
        $data->delete();
        return response()->json(['status'=> 'OK']);
        //
    }
}
