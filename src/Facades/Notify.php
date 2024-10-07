<?php

namespace Syaritech\Notify\Facades;

use Illuminate\Support\Facades\Facade;

class Notify extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'notify';
    }
}