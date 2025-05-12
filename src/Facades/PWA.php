<?php

namespace FrancisLarvelPwa\Facades;

use Illuminate\Support\Facades\Facade;

class PWA extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \FrancisLarvelPwa\Services\PWAService::class;
    }
}