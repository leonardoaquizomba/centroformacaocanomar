<?php

namespace App\Actions;

use App\Enums\EnrollmentStatus;
use App\Enums\PaymentStatus;
use App\Events\EnrollmentConfirmed;
use App\Events\PaymentReceived;
use App\Jobs\GenerateCertificateJob;
use App\Models\Payment;

class ProcessPaymentApproval
{
    public function execute(Payment $payment): void
    {
        $payment->update([
            'status' => PaymentStatus::Pago,
            'paid_at' => now(),
        ]);

        $enrollment = $payment->enrollment()->with(['user', 'course', 'courseClass', 'courseClass.teacher'])->first();

        $enrollment->update(['status' => EnrollmentStatus::Matriculado]);

        EnrollmentConfirmed::dispatch($enrollment);
        PaymentReceived::dispatch($payment->load(['enrollment.user', 'enrollment.course']));

        GenerateCertificateJob::dispatch($enrollment);
    }
}
