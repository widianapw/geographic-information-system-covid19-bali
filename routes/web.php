<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/about-me', function () {
    return view('about');
});
Route::get('/create-pallete','IndexController@createPallette');
Route::get('/','IndexController@index');
Route::get('/getDataMap','IndexController@getDataMap');
Route::post('/search','IndexController@search');
Route::resource('/data-kabupaten','DataController');
