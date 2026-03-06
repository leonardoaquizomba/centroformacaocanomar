<?php

use App\Actions\ProcessPaymentApproval;
use App\Enums\EnrollmentStatus;
use App\Enums\PaymentStatus;
use App\Jobs\GenerateCertificateJob;
use App\Mail\SendEnrollmentApprovedEmail;
use App\Mail\SendEnrollmentConfirmedEmail;
use App\Mail\SendEnrollmentReceivedEmail;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;

it('creates an enrollment with pendente status', function (): void {
    $user = User::factory()->create();
    $course = Course::factory()->create(['is_active' => true]);

    $enrollment = Enrollment::create([
        'user_id' => $user->id,
        'course_id' => $course->id,
        'status' => 'pendente',
    ]);

    expect($enrollment)->toBeInstanceOf(Enrollment::class)
        ->and($enrollment->status)->toBe(EnrollmentStatus::Pendente)
        ->and($enrollment->user_id)->toBe($user->id)
        ->and($enrollment->course_id)->toBe($course->id);
});

it('sends enrollment received email when enrollment is created', function (): void {
    Mail::fake();

    $user = User::factory()->create();
    $course = Course::factory()->create();
    $enrollment = Enrollment::factory()->create([
        'user_id' => $user->id,
        'course_id' => $course->id,
        'status' => 'pendente',
    ]);

    Mail::to($user->email)->queue(
        new SendEnrollmentReceivedEmail($enrollment->load(['user', 'course', 'courseClass']))
    );

    Mail::assertQueued(SendEnrollmentReceivedEmail::class, function (SendEnrollmentReceivedEmail $mail) use ($enrollment): bool {
        return $mail->enrollment->id === $enrollment->id;
    });
});

it('assigns aluno role to user on enrollment', function (): void {
    $user = User::factory()->create();
    expect($user->hasRole('aluno'))->toBeFalse();

    $user->assignRole('aluno');
    expect($user->hasRole('aluno'))->toBeTrue();
});

it('updates enrollment to aprovado and sends approved email', function (): void {
    Mail::fake();

    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $user = User::factory()->create();
    $course = Course::factory()->create();
    $enrollment = Enrollment::factory()->create([
        'user_id' => $user->id,
        'course_id' => $course->id,
        'status' => 'pendente',
    ]);

    $enrollment->update([
        'status' => 'aprovado',
        'approved_at' => now(),
        'approved_by' => $admin->id,
    ]);

    Mail::to($user->email)->queue(new SendEnrollmentApprovedEmail($enrollment->load(['user', 'course'])));

    Mail::assertQueued(SendEnrollmentApprovedEmail::class);

    $enrollment->refresh();
    expect($enrollment->status)->toBe(EnrollmentStatus::Aprovado)
        ->and($enrollment->approved_at)->not->toBeNull()
        ->and($enrollment->approved_by)->toBe($admin->id);
});

it('processes payment and confirms enrollment with job and email', function (): void {
    Mail::fake();
    Queue::fake();

    $user = User::factory()->create();
    $course = Course::factory()->create();
    $enrollment = Enrollment::factory()->create([
        'user_id' => $user->id,
        'course_id' => $course->id,
        'status' => 'aprovado',
    ]);
    $payment = Payment::factory()->create([
        'enrollment_id' => $enrollment->id,
        'status' => 'pendente',
    ]);

    (new ProcessPaymentApproval)->execute($payment);

    expect($payment->fresh()->status)->toBe(PaymentStatus::Pago)
        ->and($payment->fresh()->paid_at)->not->toBeNull()
        ->and($enrollment->fresh()->status)->toBe(EnrollmentStatus::Matriculado);

    Mail::assertQueued(SendEnrollmentConfirmedEmail::class);
    Queue::assertPushed(GenerateCertificateJob::class, function (GenerateCertificateJob $job) use ($enrollment): bool {
        return $job->enrollment->id === $enrollment->id;
    });
});

it('requires authentication to download a certificate', function (): void {
    $this->get(route('download.certificate', 1))->assertRedirect();
});

it('requires authentication to download an enrollment document', function (): void {
    $this->get(route('download.document', 1))->assertRedirect();
});

it('denies certificate download to user who does not own it', function (): void {
    $owner = User::factory()->create();
    $owner->assignRole('aluno');

    $other = User::factory()->create();
    $other->assignRole('aluno');

    $course = Course::factory()->create();
    $enrollment = Enrollment::factory()->create([
        'user_id' => $owner->id,
        'course_id' => $course->id,
    ]);

    $certificate = \App\Models\Certificate::create([
        'enrollment_id' => $enrollment->id,
        'user_id' => $owner->id,
        'course_id' => $course->id,
        'code' => 'CAN-2026-000001',
        'issued_at' => now(),
    ]);

    $this->actingAs($other)
        ->get(route('download.certificate', $certificate))
        ->assertForbidden();
});
