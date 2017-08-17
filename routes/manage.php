<?php

/**
 * 后台路由表
 *
 * 这里设置后台页面的主要路由
 */

//第一层（设置命令空间和前缀）
Route::group(['namespace' => 'Manage', 'prefix' => 'manage'], function () {

    $this->get('logout', 'Auth\LoginController@logout')->name('manage.logout');

    //第二层（设置未登录中间件）
    Route::group(['middleware' => 'manageguest'], function () {
        $this->get('login', 'Auth\LoginController@showLoginForm')->name('manage.login');
        $this->post('login', 'Auth\LoginController@login');
        $this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('manage.register');
        $this->post('register', 'Auth\RegisterController@register');
    });

    //第二层（设置登录中间件）
    Route::group(['middleware' => 'manageauth'], function () {

        // ---------------------------首页--------------------------- //
        Route::get('/', 'IndexController@index')->name('manage');

        // ---------------------------操作菜单管理--------------------------- //
        Route::get('/sidebar/list', 'SidebarController@view')->name('manage_sidebar_view');
        Route::get('/sidebar/add', 'SidebarController@createView')->name('manage_sidebar_add');
        Route::post('/sidebar/add', 'SidebarController@createOrUpdate');

        Route::get('/sidebar/update/{id}/{type}', 'SidebarController@update')->name('manage_sidebar_update');
        Route::post('/sidebar/update/{id}/{type}', 'SidebarController@createOrUpdate');
        Route::get('/sidebar/destroy/{id}', 'SidebarController@destroy')->name('manage_sidebar_destroy');

        // ---------------------------操作管理员管理--------------------------- //
        Route::get('/manager/list', 'ManagerController@listView')->name('manager_list');
        Route::get('/manager/add', 'ManagerController@addView')->name('manager_add');
        Route::post('/manager/add', 'ManagerController@post');
        Route::get('/manager/update/{id}', 'ManagerController@updateView')->name('manager_update');
        Route::post('/manager/update/{id}', 'ManagerController@post');
        Route::get('/manager/destroy/{id}', 'ManagerController@destroy')->name('manager_destroy');

        // ---------------------------操作管理员管理 分组管理--------------------------- //
        Route::get('/managergroup/list', 'ManagerGroupController@listView')->name('managergroup_list');
        Route::get('/managergroup/add', 'ManagerGroupController@addView')->name('managergroup_add');
        Route::post('/managergroup/add', 'ManagerGroupController@post');
        Route::get('/managergroup/update/{id}', 'ManagerGroupController@updateView')->name('managergroup_update');
        Route::post('/managergroup/update/{id}', 'ManagerGroupController@post');
        Route::get('/managergroup/destroy/{id}', 'ManagerGroupController@destroy')->name('managergroup_destroy');

        // ---------------------------操作插件管理--------------------------- //
        //第三层（设置前缀）
        Route::group(['prefix' => 'plugin'], function () {
            Route::get('/add', 'PluginController@addView')->name('plugins_add');
            Route::post('/add', 'PluginController@addPost');
            Route::get('/manage_plugins', 'PluginController@managePlugins')->name('manage_plugins');
            Route::get('/user_plugins', 'PluginController@userPlugins')->name('user_plugins');
            Route::get('/plugin_status/{plugin_id}', 'PluginController@pluginStatus')->name('plugin_status');
            Route::get('/plugin_index/{plugin_id}', 'PluginController@pluginIndex')->name('plugin_index');

            Route::get('/plugin_update/{plugin_id}', 'PluginController@updateView')->name('plugins_update');
            Route::post('/plugin_update/{plugin_id}', 'PluginController@updatePost');

            Route::get('/plugin_delete/{plugin_id}/{type}', 'PluginController@delete')->name('plugins_delete');

            Route::get('/install/{plugin_id}', 'PluginController@install')->name('plugin_install');
            Route::get('/uninstall/{plugin_id}', 'PluginController@uninstall')->name('plugin_uninstall');
        });
    });
});