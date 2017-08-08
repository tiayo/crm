<?php

namespace Plugins\Manage\Search\Providers;

use Illuminate\Support\ServiceProvider;
use Plugins\Manage\Search\Migration\CreateManageSearchTable;
use Plugins\Manage\Search\Service\IndexService;

class SearchProvider extends ServiceProvider
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
        $this->loadViewsFrom(dirname(__DIR__).'/views', 'manage_search');

        //注册配置文件
        $this->mergeConfigFrom(dirname(__DIR__).'/config/config.php', 'manage_search');

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
        $this->app->singleton('manage_search_index_service', function ($app) {
            return new IndexService();
        });

        $this->app->singleton('manage_search_migration', function ($app) {
            return new CreateManageSearchTable();
        });
    }
}
