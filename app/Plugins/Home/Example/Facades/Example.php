<?php

namespace Plugins\Home\Example\Facades;

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
        return 'home_index_service';
    }
}