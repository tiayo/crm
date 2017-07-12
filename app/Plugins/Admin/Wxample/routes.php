<?php

/**
 * 插件独立路由
 *
 */

Route::group(['namespace' => 'Plugins\Admin\Wxample\Controllers', 'prefix' => 'admin/wxample'], function () {

    Route::get('/', 'IndexController@index')->name('admin_plugin_wxample');

});