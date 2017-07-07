<?php

/**
 * 后台路由表
 *
 * 这里设置后台页面的主要路由
 */

//第一层（设置命令空间和前缀）
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

        //第三层（设置前缀）
        Route::group(['prefix' => 'plugin'], function () {
            Route::get('/add', 'PluginController@addView')->name('admin_plugins_add');
            Route::post('/add', 'PluginController@addPost')->name('admin_plugins_add_post');
            Route::get('/admin_plugins', 'PluginController@adminPlugins')->name('admin_plugins');
            Route::get('/home_plugins', 'PluginController@homePlugins')->name('home_plugins');
            Route::get('/plugin_status/{plugin_id}', 'PluginController@pluginStatus')->name('plugin_status');
            Route::get('/plugin_index/{plugin_id}', 'PluginController@pluginIndex')->name('plugin_index');

            Route::get('/plugin_update/{plugin_id}', 'PluginController@updateView')->name('admin_plugins_update');
            Route::post('/plugin_update/{plugin_id}', 'PluginController@updatePost')->name('admin_plugins_update_post');

            Route::get('/plugin_delete/{plugin_id}/{type}', 'PluginController@delete')->name('admin_plugins_delete');

            Route::get('/install/{plugin_id}', 'PluginController@install')->name('plugin_install');
            Route::get('/uninstall/{plugin_id}', 'PluginController@uninstall')->name('plugin_uninstall');


        });
    });
});