<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Mail\SendWelcomeEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendWelcomeNotification implements ShouldQueue
{
    public function handle(UserRegistered $event): void
    {
        Mail::to($event->user->email)->queue(new SendWelcomeEmail($event->user));
    }
}
