<?php

use App\Enums\EnrollmentStatus;
use App\Jobs\GenerateCertificateJob;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

it('dispatches GenerateCertificateJob to the queue', function (): void {
    \Illuminate\Support\Facades\Queue::fake();

    $user = User::factory()->create();
    $course = Course::factory()->create();
    $enrollment = Enrollment::factory()->create([
        'user_id' => $user->id,
        'course_id' => $course->id,
        'status' => EnrollmentStatus::Matriculado,
    ]);

    GenerateCertificateJob::dispatch($enrollment);

    \Illuminate\Support\Facades\Queue::assertPushed(GenerateCertificateJob::class, function (GenerateCertificateJob $job) use ($enrollment): bool {
        return $job->enrollment->id === $enrollment->id;
    });
});

it('generates and stores certificate PDF on private disk', function (): void {
    Storage::fake('private');

    Pdf::shouldReceive('loadView')
        ->once()
        ->andReturnSelf();
    Pdf::shouldReceive('setPaper')
        ->once()
        ->andReturnSelf();
    Pdf::shouldReceive('output')
        ->once()
        ->andReturn('%PDF-1.4 fake content');

    $user = User::factory()->create(['name' => 'Ana Silva']);
    $course = Course::factory()->create(['duration_hours' => 40]);
    $enrollment = Enrollment::factory()->create([
        'user_id' => $user->id,
        'course_id' => $course->id,
        'status' => EnrollmentStatus::Matriculado,
    ]);

    (new GenerateCertificateJob($enrollment))->handle();

    $certificate = Certificate::where('enrollment_id', $enrollment->id)->first();

    expect($certificate)->not->toBeNull()
        ->and($certificate->user_id)->toBe($user->id)
        ->and($certificate->course_id)->toBe($course->id)
        ->and($certificate->code)->toStartWith('CAN-')
        ->and($certificate->issued_at)->not->toBeNull()
        ->and($certificate->file_path)->toContain('certificates/');

    Storage::disk('private')->assertExists($certificate->file_path);
});

it('creates certificate with correct code format CAN-YYYY-NNNNNN', function (): void {
    Storage::fake('private');

    Pdf::shouldReceive('loadView')->andReturnSelf();
    Pdf::shouldReceive('setPaper')->andReturnSelf();
    Pdf::shouldReceive('output')->andReturn('%PDF fake');

    $user = User::factory()->create();
    $course = Course::factory()->create();
    $enrollment = Enrollment::factory()->create([
        'user_id' => $user->id,
        'course_id' => $course->id,
    ]);

    (new GenerateCertificateJob($enrollment))->handle();

    $certificate = Certificate::where('enrollment_id', $enrollment->id)->first();
    $expectedCode = 'CAN-'.now()->format('Y').'-'.str_pad((string) $enrollment->id, 6, '0', STR_PAD_LEFT);

    expect($certificate->code)->toBe($expectedCode);
});

it('upserts certificate if run twice for same enrollment', function (): void {
    Storage::fake('private');

    Pdf::shouldReceive('loadView')->andReturnSelf();
    Pdf::shouldReceive('setPaper')->andReturnSelf();
    Pdf::shouldReceive('output')->andReturn('%PDF fake');

    $user = User::factory()->create();
    $course = Course::factory()->create();
    $enrollment = Enrollment::factory()->create([
        'user_id' => $user->id,
        'course_id' => $course->id,
    ]);

    (new GenerateCertificateJob($enrollment))->handle();
    (new GenerateCertificateJob($enrollment))->handle();

    expect(Certificate::where('enrollment_id', $enrollment->id)->count())->toBe(1);
});
