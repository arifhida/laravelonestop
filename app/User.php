<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
      return $this->belongsToMany(Role::class);
    }

    public function authorizeRoles($roles)
    {
      if (is_array($roles)) {
          return $this->hasAnyRole($roles) || 
                 abort(401, 'This action is unauthorized.');
      }
      return $this->hasRole($roles) || 
             abort(401, 'This action is unauthorized.');
    }

    public function hasAnyRole($roles)
    {
      return null !== $this->roles()->whereIn('name', $roles)->first();
    }

    public function hasRole($role)
    {
      return null !== $this->roles()->where('name', $role)->first();
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
            $sortcolumn = 'email';
            break;
        default :
            $sortcolumn = 'id';
            break;
      }

      $sort_dir = ($sort_dir == 'desc')?'desc' :'asc';
      $query = DB::table('users')
                ->select('id','name','email');
      if($keyword)
        $query->where('name','like',"%$keyword%")
              ->orWhere('email','like',"%$keyword%");
      $query->orderBy($sortcolumn,$sort_dir);

      return $query;
    }
}
