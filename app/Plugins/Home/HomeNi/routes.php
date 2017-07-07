<?php

/**
 * 插件独立路由
 *
 */

Route::group(['namespace' => 'Plugins\Home\HomeNi\Controllers', 'prefix' => 'admin/homeni'], function () {

    Route::get('/', 'IndexController@index')->name('home_plugin_homeni');

});