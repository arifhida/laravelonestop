<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Role extends Model
{
    //

    protected $fillable = [
      'name', 'description'
    ];

    public function users()
    {
      return $this->belongsToMany(User::class);
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
        case 1 : 
            $sortcolumn = 'name';
            break;
        case 2 :
            $sortcolumn = 'description';
            break;
        default :
            $sortcolumn = 'id';
            break;
      }

      $sort_dir = ($sort_dir == 'desc')?'desc' :'asc';
      $query = DB::table('roles')
                ->select('id','name','description');
      if($keyword)
        $query->where('name','like',"%$keyword%")
              ->orWhere('description','like',"%$keyword%");
      $query->orderBy($sortcolumn,$sort_dir);

      return $query;
    }
}
