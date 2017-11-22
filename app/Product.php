<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Product extends Model
{

    protected $fillable =[
                'product_name','description',
                'price','url','category_id', 'active'];
    
    
    //
    public function images(){
        return $this->hasMany('App\ProductImage');
    }

    public function category(){
        return $this->belongsTo('App\Category');
    }

    public static function getData($request){       
        $keyword = $request['search']['value'];
        $sort_by = $request['order'][0]['column'];
        $sort_dir = $request['order'][0]['dir'];
        $sortcolumn = 'id';
        $query = DB::table('products')
            ->join('categories','products.category_id','=','categories.id')
            ->select('products.*','categories.name');

        switch($sort_by){
            case 0 : 
                $sortcolumn = 'products.id';
                break;
            case 1: 
                $sortcolumn = 'products.product_name';
                break;
            case 2 :
                $sortcolumn = 'products.description';
                break;
            case 3 :
                $sortcolumn = 'categories.name';
                break;
            case 4 :
                $sortcolumn = 'products.price';
                break;
            default:
                $sortcolumn = 'products.id';
        }
        $sort_dir = ($sort_dir == 'desc')?'desc' :'asc';
        if($keyword){
            $query->where('products.product_name','like',"%$keyword%")
            ->orWhere('categories.name','like',"%$keyword%")
            ->orWhere('products.description','like',"%$keyword%");
        }
        $query->orderBy($sortcolumn,$sort_dir);
        return $query;
           
    }
}
