<?php

/**
 * 插件独立路由.
 */
Route::group(['namespace' => 'Plugins\Manage\Example\Controllers', 'prefix' => 'manage/example'], function () {
    Route::get('/', 'IndexController@index')->name('manage_plugin_example');
});
