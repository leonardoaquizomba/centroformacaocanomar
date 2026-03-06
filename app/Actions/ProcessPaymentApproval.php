<?php

namespace App\Actions;

use App\Enums\EnrollmentStatus;
use App\Enums\PaymentStatus;
use App\Jobs\GenerateCertificateJob;
use App\Mail\SendEnrollmentConfirmedEmail;
use App\Models\Payment;
use Illuminate\Support\Facades\Mail;

class ProcessPaymentApproval
{
    public function execute(Payment $payment): void
    {
        $payment->update([
            'status' => PaymentStatus::Pago,
            'paid_at' => now(),
        ]);

        $enrollment = $payment->enrollment()->with(['user', 'course', 'courseClass'])->first();

        $enrollment->update(['status' => EnrollmentStatus::Matriculado]);

        Mail::to($enrollment->user->email)->queue(new SendEnrollmentConfirmedEmail($enrollment));

        GenerateCertificateJob::dispatch($enrollment);
    }
}
