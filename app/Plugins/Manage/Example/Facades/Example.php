<?php

namespace Plugins\Manage\Example\Facades;

use Illuminate\Support\Facades\Facade;

class Example extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @throws \RuntimeException
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'admin_example_index_service';
    }
}
