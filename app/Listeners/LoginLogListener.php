<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Jenssegers\Agent\Agent;
use Modules\Site\Entities\LoginLog;

class LoginLogListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $agent = new Agent();
        $email = $event->email;
        $type = $event->type;
        $status = $event->status;

        $userAgent = $agent->getUserAgent();
        $ipAddress = $event->ipAddress;
        $device = $agent->isDesktop() ? 'Desktop' : ($agent->isPhone() ? 'Phone' : ($agent->isTablet() ? 'Tablet' : 'Other'));
        $platform = $agent->platform();
        
        LoginLog::create([
            'email' => $email,
            'ip_address' => $ipAddress,
            'device' => $device,
            'platform' => $platform,
            'user_agent' => $userAgent,
            'status' => $status,
            'type' => $type,
            'message' => $event->message,
        ]);
    }
}
