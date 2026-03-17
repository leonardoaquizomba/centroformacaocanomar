<?php

namespace App\Listeners;

use App\Events\CertificateIssued;
use App\Mail\SendCertificateIssuedEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendCertificateIssuedNotification implements ShouldQueue
{
    public function handle(CertificateIssued $event): void
    {
        $certificate = $event->certificate->loadMissing(['user', 'course']);

        Mail::to($certificate->user->email)->queue(new SendCertificateIssuedEmail($certificate));
    }
}
