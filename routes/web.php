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
Route::get('/upload', function () {
    return view('test');
});
Route::post('/upload-s3', 'UploadController@uploadS3')->name('s3');
Route::post('/upload-sdk', 'UploadController@uploadSDK')->name('sdk');
Route::get('/create-bucket-sdk', 'UploadController@createAWSSDK')->name('name');
Route::get('/multi-upload', 'UploadController@UploadMulti')->name('multiUpload');
