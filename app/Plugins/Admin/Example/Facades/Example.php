<?php

namespace Plugins\Admin\Example\Facades;

use Illuminate\Support\Facades\Facade;

class Example extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor()
    {
        return 'admin_index_service';
    }
}