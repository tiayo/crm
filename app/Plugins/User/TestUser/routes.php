<?php

/**
 * 插件独立路由
 *
 */

Route::group(['middleware' => ['web', 'userauth'], 'namespace' => 'Plugins\User\TestUser\Controllers', 'prefix' => 'user/testuser'], function () {

    Route::get('/', 'IndexController@index')->name('user_plugin_testuser');

});