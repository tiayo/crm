<?php

namespace Plugins\Admin\Wxample\Providers;

use Illuminate\Support\ServiceProvider;
use Plugins\Admin\Wxample\Migration\CreateAdminWxampleTable;
use Plugins\Admin\Wxample\Service\IndexService;

class WxampleProvider extends ServiceProvider
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
        $this->loadViewsFrom(dirname(__DIR__).'/views', 'admin_wxample');

        //注册配置文件
        $this->mergeConfigFrom(dirname(__DIR__).'/config/config.php', 'admin_wxample');

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
        $this->app->singleton('admin_wxample_index_service', function ($app) {
            return new IndexService();
        });

        $this->app->singleton('admin_wxample_migration', function ($app) {
            return new CreateAdminWxampleTable();
        });
    }
}
