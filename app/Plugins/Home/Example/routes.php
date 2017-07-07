<?php

/**
 * 插件独立路由
 *
 */

Route::group(['namespace' => 'Plugins\Home\Example\Controller', 'prefix' => 'home'], function () {

    Route::get('/example', 'IndexController@index')->name('home_plugin_example');

});