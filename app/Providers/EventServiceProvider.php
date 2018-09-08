<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
//            'App\Listeners\EventListener',
        ],
        'App\Events\SendWulian' => [
            'App\Listeners\SendWulianListener',//发送物联信息
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }

    /**
     * 要注册的订阅者类.
     *
     * @var array
     */
    protected $subscribe = [
        'App\Listeners\MsnEventSubscriber',
    ];
}
