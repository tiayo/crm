<?php

namespace Plugins\Home\HomeNi\Providers;

use Illuminate\Support\ServiceProvider;
use Plugins\Home\HomeNi\Migration\CreateHomeHomeNiTable;
use Plugins\Home\HomeNi\Service\IndexService;

class HomeNiProvider extends ServiceProvider
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
        $this->loadViewsFrom(dirname(__DIR__).'/views', 'home_homeni');

        //注册配置文件
        $this->mergeConfigFrom(dirname(__DIR__).'/config/config.php', 'home_homeni');

        //注册数据库迁移文件
        $this->loadMigrationsFrom(dirname(__DIR__).'/Migrations');
    }

    /**
     * 注册应用程序服务
     *
     * @return void
     */
    public function register()
    {
        //绑定容器注入
        $this->app->singleton('home_homeni_index_service', function ($app) {
            return new IndexService();
        });

        $this->app->singleton('home_homeni_migration', function ($app) {
            return new CreateHomeHomeNiTable();
        });
    }
}
