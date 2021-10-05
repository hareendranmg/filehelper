<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Keltron\Filehelper\Filehelper;

Route::group(['namespace' => 'Keltron\Filehelper\Http\Controllers', 'middleware' => ['web'], 'prefix' => 'files'], function () {

    Route::resource('/file_helper_dashboard', 'FileHelperController');
    Route::get('/open_folder', 'FileHelperController@openFolder');

    Route::get('/get_file', function (Request $request) {
        return Filehelper::getFile($request->file_id, $request->get_type);
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
