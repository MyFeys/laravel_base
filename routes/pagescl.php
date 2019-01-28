<?php
/**
 * PhpStorm
 */
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth', 'permission:pagescl.manage']], function () {

//路由
Route::group(['middleware' => 'permission:cruds.pagescl'], function () {
    Route::get('pagescl/data', 'PagesclController@data')->name('admin.pagescl.data');
    Route::get('pagescl', 'PagesclController@index')->name('admin.pagescl');
    //添加
    Route::get('pagescl/create', 'PagesclController@create')->name('admin.pagescl.create')->middleware('permission:cruds.pagescl.create');
    Route::post('pagescl/store', 'PagesclController@store')->name('admin.pagescl.store')->middleware('permission:cruds.pagescl.create');
    //编辑
    Route::get('pagescl/{id}/edit', 'PagesclController@edit')->name('admin.pagescl.edit')->middleware('permission:cruds.pagescl.edit');
    Route::put('pagescl/{id}/update', 'PagesclController@update')->name('admin.pagescl.update')->middleware('permission:cruds.pagescl.edit');
    //删除
    Route::delete('pagescl/destroy', 'PagesclController@destroy')->name('admin.pagescl.destroy')->middleware('permission:cruds.pagescl.destroy');
});

});