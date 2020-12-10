<?php

namespace Savannabits\Koaladmin;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Savannabits\Koaladmin\Skeleton\SkeletonClass
 */
class KoaladminFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'koaladmin';
    }
}
