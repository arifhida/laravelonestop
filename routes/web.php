<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/Home/{category}', 'HomeController@product')->name('home.category');
Route::get('/Home/{product}/detail','HomeController@show')->name('home.detail');
Route::get('/category','CategoryController@index')->name('category');
Route::get('/subcategory','SubCategoryController@index')->name('subcategory');
Route::get('/subcategory/parent/{parent}','SubCategoryController@dataByParentId')->name('subcategory.parent');
Route::get('/category/data','CategoryController@data')->name('category.get');
Route::get('/subcategory/data','SubCategoryController@data')->name('subcategory.get');
Route::get('/product/data','ProductController@data')->name('product.get');
Route::resource('product', 'ProductController');
Route::resource('Image','ProductImageController',[
    'only' => [
        'store', 'destroy'
    ]
]);

Route::get('login/google', 'Auth\LoginController@redirectToProvider');
Route::get('login/google/callback', 'Auth\LoginController@handleProviderCallback');

