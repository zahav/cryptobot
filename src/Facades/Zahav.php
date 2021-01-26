<?php

namespace Zahav\ZahavLaravel\Facades;

use Illuminate\Support\Facades\Facade;

class Zahav extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'zahav';
    }
}