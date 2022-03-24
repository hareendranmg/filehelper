<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Keltron\Filehelper\Filehelper;

Route::group(['namespace' => 'Keltron\Filehelper\Http\Controllers', 'middleware' => ['web'], 'prefix' => 'files'], function () {

    Route::get('/file_helper_login', 'FileHelperAuthController@login');
    Route::post('/file_helper_login', 'FileHelperAuthController@auth');
    Route::get('/logout', 'FileHelperAuthController@logout');

    Route::resource('/file_helper_dashboard', 'FileHelperController');
    Route::get('/open_folder', 'FileHelperController@openFolder');

    Route::get('/get_file', function (Request $request) {
        return Filehelper::getFile($request->file_id, $request->get_type);
    });
    Route::get('/get_file_type_image_from_id', function (Request $request) {
        return Filehelper::getFileTypeImageFromId($request->file_path);
    });
    Route::get('/get_file_type_image_from_path', function (Request $request) {
        return Filehelper::getFileTypeImageFromPath($request->file_path);
    });
    Route::get('/get_file_from_path', function (Request $request) {
        return Filehelper::getFileFromPath($request->file_path, $request->get_type);
    });
    Route::get('/get_file_info', function (Request $request) {
        return Filehelper::getFileInfo($request->file_id);
    });
    Route::get('/get_file_binary', function (Request $request) {
        return Filehelper::getFileBinary($request->file_id);
    });
    Route::get('/delete_file', function (Request $request) {
        return Filehelper::deleteFile($request->file_id);
    });

});
