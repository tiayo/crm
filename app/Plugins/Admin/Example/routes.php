<?php

/**
 * 插件独立路由
 *
 */

Route::group(['namespace' => 'Plugins\Admin\Example\Controller', 'prefix' => 'admin'], function () {

    Route::get('/example', 'IndexController@index');

});