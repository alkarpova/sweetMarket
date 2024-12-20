<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Cart
 *
 * @method static \Mockery\MockInterface spy() Convert the facade into a Mockery spy.
 * @method static \Mockery\MockInterface partialMock() Initiate a partial mock on the facade.
 * @method static \Mockery\Expectation shouldReceive(string|array ...$methodNames) Initiate a mock expectation on the facade.
 * @method static void swap($instance) Hotswap the underlying instance behind the facade.
 * @method static void clearResolvedInstance(string $name) Clear a resolved facade instance.
 * @method static void clearResolvedInstances() Clear all of the resolved instances.
 *
 * @see \App\Services\CartService
 */
class Cart extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Cart';
    }
}
