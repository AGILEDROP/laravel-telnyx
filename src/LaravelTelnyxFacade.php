<?php

namespace AGILEDROP\LaravelTelnyx;

use Illuminate\Support\Facades\Facade;

/**
 * @see \AGILEDROP\LaravelTelnyx\LaravelTelnyx
 */
class LaravelTelnyxFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-telnyx';
    }
}
