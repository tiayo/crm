<?php

/**
 * 插件独立路由
 *
 */

Route::group(['namespace' => 'Plugins\Admin\Example\Controllers', 'prefix' => 'admin/example'], function () {

    Route::get('/', 'IndexController@index')->name('admin_plugin_example');

});