<?php

namespace Plugins\Manage\Example\Providers;

use Illuminate\Support\ServiceProvider;
use Plugins\Manage\Example\Migration\CreateAdminExampleTable;
use Plugins\Manage\Example\Service\IndexService;

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
        $this->loadViewsFrom(dirname(__DIR__).'/views', 'admin_example');

        //注册配置文件
        $this->mergeConfigFrom(dirname(__DIR__).'/config/config.php', 'admin_example');

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
        $this->app->singleton('admin_example_index_service', function ($app) {
            return new IndexService();
        });

        $this->app->singleton('admin_example_migration', function ($app) {
            return new CreateAdminExampleTable();
        });
    }
}
