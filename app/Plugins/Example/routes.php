<?php

/**
 * 插件独立路由
 *
 */

Route::group(['namespace' => 'App\Plugins\Example\Controller'], function () {

    Route::get('/example', 'IndexController@index');

});