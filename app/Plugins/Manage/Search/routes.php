<?php

/**
 * 插件独立路由
 *
 */

Route::group(['middleware' => ['web', 'manageauth'], 'namespace' => 'Plugins\Manage\Search\Controllers', 'prefix' => 'manage/search'], function () {

    Route::get('/', 'IndexController@index')->name('manage_plugin_search');

});