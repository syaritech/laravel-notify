<?php

namespace Syaritech\Notify\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin \Syaritech\Notify\Notify
 */
class Notify extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'notify';
    }
}