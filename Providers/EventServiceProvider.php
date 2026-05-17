<?php

namespace Modules\Shop\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [

        // Shop events
        \Modules\Shop\Events\ShopOrderCreate::class => [
            \Modules\Shop\Listeners\HandleShopOrderCreate::class,
        ],

        \Modules\Shop\Events\ShopProductUpdated::class => [
           // \Modules\Shop\Listeners\HandleShopProductUpdated::class,
        ],

        \Modules\Shop\Events\ShopProductDeleted::class => [
          //  \Modules\Shop\Listeners\HandleShopProductDeleted::class,
        ],
        

    ];
}
