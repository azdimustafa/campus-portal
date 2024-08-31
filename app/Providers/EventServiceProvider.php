<?php

namespace App\Providers;

use App\Events\CreateOrUpdateUser;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

## login history
use App\Events\LoginHistory;
use App\Events\LoginLog;
use App\Events\LoginLogEvent;
use App\Listeners\storeUserLoginHistory;

## manage user local
use App\Events\ManageUserLocal;
use App\Listeners\StoreUserLocal;


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
        LoginHistory::class => [
            StoreUserLoginHistory::class,
        ],
        ManageUserLocal::class => [
            StoreUserLocal::class,
        ],
        CreateOrUpdateUser::class => [
            \App\Listeners\CreateOrUpdateUserListener::class,
        ],
        LoginLog::class => [
            \App\Listeners\LoginLogListener::class,
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
}
