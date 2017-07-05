<?php

namespace Plugins\Example\Service;

class IndexService
{
    public function dependency()
    {
        return '依赖注入成功！';
    }

    public function app()
    {
        return '容器注入成功！';
    }

    public function facade()
    {
        return 'Facade成功！';
    }
}