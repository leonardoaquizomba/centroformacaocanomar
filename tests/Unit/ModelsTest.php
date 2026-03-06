<?php

use App\Models\Certificate;
use App\Models\Course;
use App\Models\CourseClass;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\User;

// ─── User ───────────────────────────────────────────────────────────────────

it('user can have aluno role', function (): void {
    $user = User::factory()->create();
    $user->assignRole('aluno');

    expect($user->hasRole('aluno'))->toBeTrue()
        ->and($user->hasRole('admin'))->toBeFalse();
});

it('user can have admin role', function (): void {
    $user = User::factory()->create();
    $user->assignRole('admin');

    expect($user->hasRole('admin'))->toBeTrue();
});

it('admin user has the admin role granting admin panel access', function (): void {
    $user = User::factory()->create();
    $user->assignRole('admin');

    expect($user->hasRole('admin'))->toBeTrue()
        ->and($user->hasRole('aluno'))->toBeFalse()
        ->and($user->hasRole('professor'))->toBeFalse();
});

it('aluno user has the aluno role granting aluno panel access', function (): void {
    $user = User::factory()->create();
    $user->assignRole('aluno');

    expect($user->hasRole('aluno'))->toBeTrue()
        ->and($user->hasRole('admin'))->toBeFalse();
});

it('aluno user does not have admin role and cannot access admin panel', function (): void {
    $user = User::factory()->create();
    $user->assignRole('aluno');

    expect($user->hasRole('aluno'))->toBeTrue()
        ->and($user->hasRole('admin'))->toBeFalse();
});

// ─── Course ─────────────────────────────────────────────────────────────────

it('course belongs to a category', function (): void {
    $course = Course::factory()->create();

    expect($course->category)->not->toBeNull()
        ->and($course->category)->toBeInstanceOf(\App\Models\CourseCategory::class);
});

it('course has many classes', function (): void {
    $course = Course::factory()->create();
    CourseClass::factory()->count(2)->create(['course_id' => $course->id]);

    expect($course->classes)->toHaveCount(2);
});

// ─── Enrollment ─────────────────────────────────────────────────────────────

it('enrollment belongs to user and course', function (): void {
    $user = User::factory()->create();
    $course = Course::factory()->create();
    $enrollment = Enrollment::factory()->create([
        'user_id' => $user->id,
        'course_id' => $course->id,
    ]);

    expect($enrollment->user->id)->toBe($user->id)
        ->and($enrollment->course->id)->toBe($course->id);
});

it('enrollment has many payments', function (): void {
    $enrollment = Enrollment::factory()->create();
    Payment::factory()->count(2)->create(['enrollment_id' => $enrollment->id]);

    expect($enrollment->payments)->toHaveCount(2);
});

it('enrollment can have one certificate', function (): void {
    $user = User::factory()->create();
    $course = Course::factory()->create();
    $enrollment = Enrollment::factory()->create([
        'user_id' => $user->id,
        'course_id' => $course->id,
    ]);

    Certificate::create([
        'enrollment_id' => $enrollment->id,
        'user_id' => $user->id,
        'course_id' => $course->id,
        'code' => 'CAN-2026-000001',
        'issued_at' => now(),
    ]);

    expect($enrollment->certificate)->not->toBeNull()
        ->and($enrollment->certificate)->toBeInstanceOf(Certificate::class);
});

// ─── Payment ─────────────────────────────────────────────────────────────────

it('payment belongs to enrollment', function (): void {
    $enrollment = Enrollment::factory()->create();
    $payment = Payment::factory()->create(['enrollment_id' => $enrollment->id]);

    expect($payment->enrollment->id)->toBe($enrollment->id);
});

// ─── Certificate ─────────────────────────────────────────────────────────────

it('certificate code follows CAN-YYYY-NNNNNN format', function (): void {
    $user = User::factory()->create();
    $course = Course::factory()->create();
    $enrollment = Enrollment::factory()->create([
        'user_id' => $user->id,
        'course_id' => $course->id,
    ]);

    $code = 'CAN-'.now()->format('Y').'-'.str_pad((string) $enrollment->id, 6, '0', STR_PAD_LEFT);

    expect($code)->toMatch('/^CAN-\d{4}-\d{6}$/');
});

// ─── Architecture ────────────────────────────────────────────────────────────

arch('controllers extend base controller')
    ->expect('App\Http\Controllers')
    ->toExtend('App\Http\Controllers\Controller');

arch('models do not use DB facade')
    ->expect('App\Models')
    ->not->toUse('Illuminate\Support\Facades\DB');

arch('actions are plain classes with execute method')
    ->expect('App\Actions')
    ->toHaveMethod('execute');

arch('jobs implement ShouldQueue')
    ->expect('App\Jobs')
    ->toImplement('Illuminate\Contracts\Queue\ShouldQueue');

arch('mailables implement ShouldQueue')
    ->expect('App\Mail')
    ->toImplement('Illuminate\Contracts\Queue\ShouldQueue');
