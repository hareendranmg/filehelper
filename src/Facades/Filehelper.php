<?php

namespace Keltron\Filehelper\Facades;

use Illuminate\Support\Facades\Facade;

class Filehelper extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'filehelper';
    }
}
