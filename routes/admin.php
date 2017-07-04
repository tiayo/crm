<?php

/**
 * 后台路由表
 *
 * 这里设置后台页面的主要路由
 */

//第一层（设置命令空间）
Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {

    $this->get('logout', 'Auth\LoginController@logout')->name('admin.logout');

    //第二层（设置未登录中间件）
    Route::group(['middleware' => 'adminguest'], function () {
        $this->get('login', 'Auth\LoginController@showLoginForm')->name('admin.login');
        $this->post('login', 'Auth\LoginController@login');
        $this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('admin.register');
        $this->post('register', 'Auth\RegisterController@register');
    });

    //第二层（设置登录中间件）
    Route::group(['middleware' => 'adminauth'], function () {

        Route::get('/', 'AdminController@index')->name('admin');
        Route::get('/test/{id}', 'AdminController@test');

    });
});