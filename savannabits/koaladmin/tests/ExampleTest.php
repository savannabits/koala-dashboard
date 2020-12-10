<?php

namespace Savannabits\Koaladmin\Tests;

use Orchestra\Testbench\TestCase;
use Savannabits\Koaladmin\KoaladminServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [KoaladminServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
