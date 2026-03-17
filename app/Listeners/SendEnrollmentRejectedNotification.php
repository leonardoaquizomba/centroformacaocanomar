<?php

namespace App\Listeners;

use App\Events\EnrollmentRejected;
use App\Mail\SendEnrollmentRejectedEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendEnrollmentRejectedNotification implements ShouldQueue
{
    public function handle(EnrollmentRejected $event): void
    {
        $enrollment = $event->enrollment->loadMissing(['user', 'course', 'courseClass']);

        Mail::to($enrollment->user->email)->queue(new SendEnrollmentRejectedEmail($enrollment));
    }
}
