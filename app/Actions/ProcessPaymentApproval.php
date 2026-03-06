<?php

namespace App\Actions;

use App\Jobs\GenerateCertificateJob;
use App\Mail\SendEnrollmentConfirmedEmail;
use App\Models\Payment;
use Illuminate\Support\Facades\Mail;

class ProcessPaymentApproval
{
    public function execute(Payment $payment): void
    {
        $payment->update([
            'status' => 'pago',
            'paid_at' => now(),
        ]);

        $enrollment = $payment->enrollment()->with(['user', 'course', 'courseClass'])->first();

        $enrollment->update(['status' => 'confirmado']);

        Mail::to($enrollment->user->email)->queue(new SendEnrollmentConfirmedEmail($enrollment));

        GenerateCertificateJob::dispatch($enrollment);
    }
}
