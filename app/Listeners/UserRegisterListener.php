<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\RegisteredUserNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;;

class UserRegisterListener implements ShouldQueue
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
        $admins = User::where('is_admin', 1)->get();
        Notification::send($admins, new RegisteredUserNotification($event->user));
    }
}
