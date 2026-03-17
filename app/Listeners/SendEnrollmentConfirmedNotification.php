<?php

namespace App\Listeners;

use App\Events\EnrollmentConfirmed;
use App\Mail\SendEnrollmentConfirmedEmail;
use App\Mail\SendStudentConfirmedTeacherEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendEnrollmentConfirmedNotification implements ShouldQueue
{
    public function handle(EnrollmentConfirmed $event): void
    {
        $enrollment = $event->enrollment->loadMissing(['user', 'course', 'courseClass', 'courseClass.teacher']);

        Mail::to($enrollment->user->email)->queue(new SendEnrollmentConfirmedEmail($enrollment));

        if ($enrollment->courseClass?->teacher_id) {
            Mail::to($enrollment->courseClass->teacher->email)->queue(new SendStudentConfirmedTeacherEmail($enrollment));
        }
    }
}
