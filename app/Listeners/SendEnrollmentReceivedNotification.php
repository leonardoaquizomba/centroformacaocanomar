<?php

namespace App\Listeners;

use App\Events\EnrollmentSubmitted;
use App\Mail\SendEnrollmentReceivedEmail;
use App\Mail\SendNewEnrollmentAdminEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendEnrollmentReceivedNotification implements ShouldQueue
{
    public function handle(EnrollmentSubmitted $event): void
    {
        $enrollment = $event->enrollment->loadMissing(['user', 'course', 'courseClass']);

        Mail::to($enrollment->user->email)->queue(new SendEnrollmentReceivedEmail($enrollment));
        Mail::to(config('mail.admin_address'))->queue(new SendNewEnrollmentAdminEmail($enrollment));
    }
}
