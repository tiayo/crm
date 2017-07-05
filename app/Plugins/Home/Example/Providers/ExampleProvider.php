<?php

namespace Plugins\Home\Example\Providers;

use Illuminate\Support\ServiceProvider;
use Plugins\Home\Example\Service\IndexService;

class ExampleProvider extends ServiceProvider
{
    /**
     * 引导应用程序服务
     *
     * @return void
     */
    public function boot()
    {
        //注册路由
        $this->loadRoutesFrom(dirname(__DIR__).'/routes.php');

        //注册视图
        $this->loadViewsFrom(dirname(__DIR__).'/views', 'home_example');

        //注册配置文件
        $this->mergeConfigFrom(dirname(__DIR__).'/config/config.php', 'home_example');
    }

    /**
     * 注册应用程序服务
     *
     * @return void
     */
    public function register()
    {
        //绑定容器注入
        $this->app->singleton('home_index_service', function ($app) {
            return new IndexService();
        });
    }
}