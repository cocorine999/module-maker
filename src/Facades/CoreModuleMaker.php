<?php

namespace LaravelCoreModule\CoreModuleMaker\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \LaravelCoreModule\CoreModuleMaker\CoreModuleMaker
 */
class CoreModuleMaker extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \LaravelCoreModule\CoreModuleMaker\CoreModuleMaker::class;
    }
}
