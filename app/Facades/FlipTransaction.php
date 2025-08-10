<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class FlipTransaction extends Facade
{
    protected static function getFacadeAccessor():string
    {
        return "flipTransaction";
    }
}