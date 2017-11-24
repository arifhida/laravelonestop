<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class SubCategory extends Model
{
    protected $fillable =[
        'name','active','category_id'
    ];
    

    public function category(){
        return $this->belongsTo('App\Category');
    }

    public static function getData($request){
        $keyword = $request['search']['value'];
        $sort_by = $request['order'][0]['column'];
        $sort_dir = $request['order'][0]['dir'];
        $sortcolumn = 'id';
        switch($sort_by){
            case 0 : 
                $sortcolumn = 'sub_categories.id';
                break;
            case 1: 
                $sortcolumn = 'sub_categories.name';
                break;
            case 2 :
                $sortcolumn = 'categories.name';
                break;
            case 3 :
                $sortcolumn = 'sub_categories.active';
                break;
            default:
                $sortcolumn = 'sub_categories.id';
        }
        $sort_dir = ($sort_dir == 'desc')?'desc' :'asc';
        $query = DB::table('sub_categories')
            ->join('categories','sub_categories.category_id','=','categories.id')
            ->select('sub_categories.*','categories.name as category','categories.icon');
        if($keyword)
            $query->where('sub_categories.name','like',"%$keyword%");
        $query->orderBy($sortcolumn,$sort_dir);

        return $query;
    }
}
