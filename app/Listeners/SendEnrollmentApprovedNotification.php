<?php

namespace App\Listeners;

use App\Events\EnrollmentApproved;
use App\Mail\SendEnrollmentApprovedEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendEnrollmentApprovedNotification implements ShouldQueue
{
    public function handle(EnrollmentApproved $event): void
    {
        $enrollment = $event->enrollment->loadMissing(['user', 'course', 'courseClass']);

        Mail::to($enrollment->user->email)->queue(new SendEnrollmentApprovedEmail($enrollment));
    }
}
