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
Route::get('/category','CategoryController@index')->name('category');
// Route::post('/category','CategoryController@store')->name('category.store');
Route::get('/category/data','CategoryController@data')->name('category.get');
Route::get('/product/data','ProductController@data')->name('product.get');
Route::resource('product', 'ProductController');

