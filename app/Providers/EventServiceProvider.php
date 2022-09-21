<?php

namespace App\Providers;

use App\Events\OrderCreateEvent;
use App\Listeners\OrderSendNotificationListener;
use Illuminate\Auth\Events\Registered;
use App\Events\AdminLoginHistoryEvent;
use App\Listeners\AdminLoginHistoryListener;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Event;
use App\Listeners\IsAllSettingsDoneListener;
use App\Events\IsAllSettingDoneEvent;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        AdminLoginHistoryEvent::class =>[
            AdminLoginHistoryListener::class,
        ],
        IsAllSettingDoneEvent::class => [
            IsAllSettingsDoneListener::class,
        ],
        OrderCreateEvent::class => [
            OrderSendNotificationListener::class,
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {

    }
}
