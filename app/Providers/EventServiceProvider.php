<?php

namespace App\Providers;

use App\Events\AdminLoginHistoryEvent;
use App\Events\CreateSlotBookingEvent;
use App\Events\DineOutBookingEvent;
use App\Events\IsAllSettingDoneEvent;
use App\Events\OrderCreateEvent;
use App\Events\OrderSendToPrepareEvent;
use App\Events\OrderReadyToDispatchEvent;
use App\Events\SlotBookingAcceptEvent;
use App\Events\SlotBookingRejectEvent;
use App\Listeners\AdminLoginHistoryListener;
use App\Listeners\CreateSlotBookingNotificationListener;
use App\Listeners\DineOutBookingNotificationListener;
use App\Listeners\IsAllSettingsDoneListener;
use App\Listeners\OrderSendNotificationListener;
use App\Listeners\OrderSendToPreparationNotificationListener;
use App\Listeners\SlotBookingAcceptNotificationListener;
use App\Listeners\SlotBookingRejectNotificationListener;
use App\Listeners\OrderReadyToDispatchListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen
        = [
            Registered::class               => [SendEmailVerificationNotification::class,],
            AdminLoginHistoryEvent::class   => [AdminLoginHistoryListener::class,],
            IsAllSettingDoneEvent::class    => [IsAllSettingsDoneListener::class,],
            OrderCreateEvent::class         => [OrderSendNotificationListener::class,],
            OrderSendToPrepareEvent::class  => [OrderSendToPreparationNotificationListener::class,],
            CreateSlotBookingEvent::class   => [CreateSlotBookingNotificationListener::class],
            SlotBookingAcceptEvent::class   => [SlotBookingAcceptNotificationListener::class],
            SlotBookingRejectEvent::class   => [SlotBookingRejectNotificationListener::class],
            DineOutBookingEvent::class      => [DineOutBookingNotificationListener::class],
            OrderReadyToDispatchEvent::class => [OrderReadyToDispatchListener::class],
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
