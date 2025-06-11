<?php

namespace Nika\LaravelComments\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Nika\LaravelComments\LaravelComments
 */
class LaravelComments extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Nika\LaravelComments\LaravelComments::class;
    }
}
