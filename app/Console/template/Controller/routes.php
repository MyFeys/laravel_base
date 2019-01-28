<?php
/**
 * PhpStorm
 */
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth', 'permission:kang.manage']], function () {

//路由
Route::group(['middleware' => 'permission:cruds.tag'], function () {
    Route::get('tag/data', 'TagController@data')->name('admin.tag.data');
    Route::get('tag', 'TagController@index')->name('admin.tag');
    //添加
    Route::get('tag/create', 'TagController@create')->name('admin.tag.create')->middleware('permission:cruds.tag.create');
    Route::post('tag/store', 'TagController@store')->name('admin.tag.store')->middleware('permission:cruds.tag.create');
    //编辑
    Route::get('tag/{id}/edit', 'TagController@edit')->name('admin.tag.edit')->middleware('permission:cruds.tag.edit');
    Route::put('tag/{id}/update', 'TagController@update')->name('admin.tag.update')->middleware('permission:cruds.tag.edit');
    //删除
    Route::delete('tag/destroy', 'TagController@destroy')->name('admin.tag.destroy')->middleware('permission:cruds.tag.destroy');
});

});