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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/imageUpload', 'ImageUploadController@index')->name('image');
Route::post('imageUpload', 'ImageUploadController@store')->name('image.upload');
Route::post('smushUpload', 'ImageUploadController@smush')->name('image.upload-smush');

Route::middleware('optimizeImages')->group(function () {
    // all images will be optimized automatically
    Route::post('spatieUpload', 'ImageUploadController@spatie')->name('image.upload-spatie');
});

