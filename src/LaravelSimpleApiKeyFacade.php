<?php

namespace Kustomrt\LaravelSimpleApiKey;

use Illuminate\Support\Facades\Facade;

/**
 * @see LaravelSimpleApiKey
 */
class LaravelSimpleApiKeyFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-simple-api-key';
    }
}
