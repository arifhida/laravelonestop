<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::resource('category', 'CategoryController',[
    'except' => [
        'index','create','edit'
    ]
]);
Route::resource('subcategory', 'SubCategoryController',[
    'except' => [
        'index','create','edit'
    ]
]);
Route::resource('usermanagement','UserManagementController',[
    'except' => [
        'index','create','edit'
    ]
]);
Route::get('/category/data','CategoryController@data')->name('category.data');
Route::get('/product/data','ProductController@data')->name('product.data');

Route::resource('product','ProductController',[
    'except' => [
        'index','create','edit'
    ]
]);
Route::get('role/data','RoleController@data')->name('role.data');
Route::resource('role', 'RoleController',[
    'except' => [
        'index','create','edit'
    ]
]);
