<?php

namespace App\Listeners;

use App\Events\PaymentReceived;
use App\Mail\SendPaymentReceivedAdminEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendPaymentReceivedNotification implements ShouldQueue
{
    public function handle(PaymentReceived $event): void
    {
        $payment = $event->payment->loadMissing(['enrollment.user', 'enrollment.course']);

        Mail::to(config('mail.admin_address'))->queue(new SendPaymentReceivedAdminEmail($payment));
    }
}
