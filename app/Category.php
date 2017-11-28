<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
Use DB;

class Category extends Model
{
    //
    protected $fillable =[
        'name','active','icon'
    ];

    public function subcategories(){
        return $this->hasMany('App\SubCategory');
    }  


    public function products(){
        return $this->hasMany('App\Product');
    }  
    
    
    public function productshome(){
        return $this->hasMany('App\Product')->where('active','=',1)->orderBy('id','desc');
    }

    public static function getData($request){        
        $keyword = $request['search']['value'];
        $sort_by = $request['order'][0]['column'];
        $sort_dir = $request['order'][0]['dir'];
        $sortcolumn = 'id';
        switch($sort_by){
            case 0 : 
                $sortcolumn = 'id';
                break;
            case 1: 
                $sortcolumn = 'name';
                break;
            case 2 :
                $sortcolumn = 'active';
                break;
            default:
                $sortcolumn = 'id';
        }
        $sort_dir = ($sort_dir == 'desc')?'desc' :'asc';
        $query = DB::table('categories');
        if($keyword)
            $query->where('name','like',"%$keyword%");

        $query->orderBy($sortcolumn,$sort_dir);

        return $query->select('id','name','icon','active');
    }
}
