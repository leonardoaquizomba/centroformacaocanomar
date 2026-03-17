<?php

use App\Events\CertificateIssued;
use App\Events\EnrollmentApproved;
use App\Events\EnrollmentConfirmed;
use App\Events\EnrollmentRejected;
use App\Events\EnrollmentSubmitted;
use App\Events\PaymentReceived;
use App\Listeners\SendCertificateIssuedNotification;
use App\Listeners\SendEnrollmentApprovedNotification;
use App\Listeners\SendEnrollmentConfirmedNotification;
use App\Listeners\SendEnrollmentReceivedNotification;
use App\Listeners\SendEnrollmentRejectedNotification;
use App\Listeners\SendPaymentReceivedNotification;
use App\Mail\SendCertificateIssuedEmail;
use App\Mail\SendEnrollmentApprovedEmail;
use App\Mail\SendEnrollmentConfirmedEmail;
use App\Mail\SendEnrollmentReceivedEmail;
use App\Mail\SendEnrollmentRejectedEmail;
use App\Mail\SendNewEnrollmentAdminEmail;
use App\Mail\SendPaymentReceivedAdminEmail;
use App\Mail\SendStudentConfirmedTeacherEmail;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\CourseClass;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

it('dispatches enrollment received and admin mails on EnrollmentSubmitted', function (): void {
    Mail::fake();

    $user = User::factory()->create();
    $course = Course::factory()->create();
    $enrollment = Enrollment::factory()->create(['user_id' => $user->id, 'course_id' => $course->id]);
    $enrollment->load(['user', 'course', 'courseClass']);

    $listener = new SendEnrollmentReceivedNotification;
    $listener->handle(new EnrollmentSubmitted($enrollment));

    Mail::assertQueued(SendEnrollmentReceivedEmail::class, fn ($mail) => $mail->enrollment->id === $enrollment->id);
    Mail::assertQueued(SendNewEnrollmentAdminEmail::class, fn ($mail) => $mail->enrollment->id === $enrollment->id);
});

it('dispatches enrollment approved mail on EnrollmentApproved', function (): void {
    Mail::fake();

    $user = User::factory()->create();
    $course = Course::factory()->create();
    $enrollment = Enrollment::factory()->create(['user_id' => $user->id, 'course_id' => $course->id]);
    $enrollment->load(['user', 'course', 'courseClass']);

    $listener = new SendEnrollmentApprovedNotification;
    $listener->handle(new EnrollmentApproved($enrollment));

    Mail::assertQueued(SendEnrollmentApprovedEmail::class, fn ($mail) => $mail->enrollment->id === $enrollment->id);
});

it('dispatches enrollment rejected mail on EnrollmentRejected', function (): void {
    Mail::fake();

    $user = User::factory()->create();
    $course = Course::factory()->create();
    $enrollment = Enrollment::factory()->create([
        'user_id' => $user->id,
        'course_id' => $course->id,
        'rejection_reason' => 'Documentação incompleta.',
    ]);
    $enrollment->load(['user', 'course', 'courseClass']);

    $listener = new SendEnrollmentRejectedNotification;
    $listener->handle(new EnrollmentRejected($enrollment));

    Mail::assertQueued(SendEnrollmentRejectedEmail::class, fn ($mail) => $mail->enrollment->id === $enrollment->id);
});

it('dispatches confirmed mail to student on EnrollmentConfirmed', function (): void {
    Mail::fake();

    $user = User::factory()->create();
    $course = Course::factory()->create();
    $enrollment = Enrollment::factory()->create(['user_id' => $user->id, 'course_id' => $course->id]);
    $enrollment->load(['user', 'course', 'courseClass', 'courseClass.teacher']);

    $listener = new SendEnrollmentConfirmedNotification;
    $listener->handle(new EnrollmentConfirmed($enrollment));

    Mail::assertQueued(SendEnrollmentConfirmedEmail::class, fn ($mail) => $mail->enrollment->id === $enrollment->id);
    Mail::assertNotQueued(SendStudentConfirmedTeacherEmail::class);
});

it('dispatches confirmed mail to teacher when class has a teacher', function (): void {
    Mail::fake();

    $teacher = User::factory()->create();
    $teacher->assignRole('professor');

    $student = User::factory()->create();
    $student->assignRole('aluno');

    $course = Course::factory()->create();
    $class = CourseClass::factory()->create(['course_id' => $course->id, 'teacher_id' => $teacher->id]);

    $enrollment = Enrollment::factory()->create([
        'user_id' => $student->id,
        'course_id' => $course->id,
        'course_class_id' => $class->id,
    ]);
    $enrollment->load(['user', 'course', 'courseClass', 'courseClass.teacher']);

    $listener = new SendEnrollmentConfirmedNotification;
    $listener->handle(new EnrollmentConfirmed($enrollment));

    Mail::assertQueued(SendEnrollmentConfirmedEmail::class);
    Mail::assertQueued(SendStudentConfirmedTeacherEmail::class, fn ($mail) => $mail->enrollment->id === $enrollment->id);
});

it('dispatches payment received admin mail on PaymentReceived', function (): void {
    Mail::fake();

    $user = User::factory()->create();
    $course = Course::factory()->create();
    $enrollment = Enrollment::factory()->create(['user_id' => $user->id, 'course_id' => $course->id]);
    $payment = Payment::factory()->create(['enrollment_id' => $enrollment->id]);
    $payment->load(['enrollment.user', 'enrollment.course']);

    $listener = new SendPaymentReceivedNotification;
    $listener->handle(new PaymentReceived($payment));

    Mail::assertQueued(SendPaymentReceivedAdminEmail::class, fn ($mail) => $mail->payment->id === $payment->id);
});

it('dispatches certificate issued mail on CertificateIssued', function (): void {
    Mail::fake();

    $user = User::factory()->create();
    $course = Course::factory()->create();
    $enrollment = Enrollment::factory()->create(['user_id' => $user->id, 'course_id' => $course->id]);
    $certificate = Certificate::create([
        'enrollment_id' => $enrollment->id,
        'user_id' => $user->id,
        'course_id' => $course->id,
        'code' => 'CAN-2026-000099',
        'issued_at' => now(),
    ]);
    $certificate->load(['user', 'course']);

    $listener = new SendCertificateIssuedNotification;
    $listener->handle(new CertificateIssued($certificate));

    Mail::assertQueued(SendCertificateIssuedEmail::class, fn ($mail) => $mail->certificate->id === $certificate->id);
});
