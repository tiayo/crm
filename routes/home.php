<?php

/**
 * 前端路由表
 *
 * 这里设置前端页面的主要路由
 */

//第一层（设置命令空间）
Route::group(['namespace' => 'Home'], function () {
    // Authentication Routes...
    $this->get('login', 'Auth\LoginController@showLoginForm')->name('home.login');
    $this->post('login', 'Auth\LoginController@login');
    $this->get('logout', 'Auth\LoginController@logout')->name('home.logout');

    // Registration Routes...
    $this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('home.register');
    $this->post('register', 'Auth\RegisterController@register');

    // Password Reset Routes...
    $this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    $this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    $this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    $this->post('password/reset', 'Auth\ResetPasswordController@reset');

    //第二层（设置登录中间件）
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/home', function (){
            echo '前台用户id：'.Auth::id();
        })->name('home');
    });
});