<?php

namespace App\Http\Controllers;
use App\User as User;

use Illuminate\Http\Request;

class UserManagementController extends Controller
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
        //
        // $data = User::all();
        return View('usermanagement.index');
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


    public function data(Request $request){

        // return response()->json('OK');
        $start = $request['start'];
        $length = $request['length'];
        $data = User::getData($request->all());
        // dd($data->get());
        $recordsFiltered = $data->get()->count();
        $result = $data->skip($start)->take($length)->get();
        $draw = $request->draw + 1;
        $recordsTotal = User::all()->count();

        return response()->json(['draw'=> $draw, 'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered, 'data' => $result ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6'
        ]);
        $input = $request->all();
        
        User::create([
            'name'=> $input['name'],
            'email' => $input['email'],
            'password' => bcrypt($input['password']),
        ]);

        return response()->json(['status' => "OK"]);
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
        $data = User::with('roles')->find($id);
        return response()->json(['user'=> $data]);
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
        $this->validate($request,[
            'name' => 'required|string|max:255'
        ]);
        // dd($request->password);
        $data = User::findOrFail($id);
        $input = $request->all();
        if($request->has('password')){
            $password = bcrypt($input['password']);
            $data->password = $password;
        }
            
            
        $data->name = $input['name'];
        

        $data->save();
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

        $data = User::find($id);
        $data->delete();
        return response()->json(['status'=> 'OK']);
        //
    }
}
