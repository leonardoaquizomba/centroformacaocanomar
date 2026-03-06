<?php

use App\Enums\DayOfWeek;
use App\Filament\Aluno\Pages\EditStudentProfile;
use App\Filament\Aluno\Pages\MyCalendarPage;
use App\Models\CourseClass;
use App\Models\Enrollment;
use App\Models\Schedule;
use App\Models\StudentProfile;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->student = User::factory()->create();
    $this->student->assignRole('aluno');
});

// ─── T-033: MyCalendarPage ────────────────────────────────────────────────────

it('student can access the calendar page', function (): void {
    $this->actingAs($this->student)
        ->get('/aluno/my-calendar-page')
        ->assertSuccessful();
});

it('non-aluno user is forbidden from calendar page', function (): void {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $this->actingAs($admin)
        ->get('/aluno/my-calendar-page')
        ->assertForbidden();
});

it('calendar page shows empty state when student has no active enrollments', function (): void {
    Livewire::actingAs($this->student)
        ->test(MyCalendarPage::class)
        ->assertSee('Não tem aulas agendadas.');
});

it('calendar page shows schedule data for enrolled active classes', function (): void {
    $courseClass = CourseClass::factory()->create(['is_active' => true]);

    Schedule::create([
        'course_class_id' => $courseClass->id,
        'day_of_week' => DayOfWeek::Segunda,
        'start_time' => '08:00',
        'end_time' => '10:00',
        'location' => 'Sala 1',
    ]);

    Enrollment::factory()->create([
        'user_id' => $this->student->id,
        'course_id' => $courseClass->course_id,
        'course_class_id' => $courseClass->id,
    ]);

    Livewire::actingAs($this->student)
        ->test(MyCalendarPage::class)
        ->assertSee($courseClass->course->name)
        ->assertSee('08:00')
        ->assertSee('Sala 1');
});

// ─── T-034: EditStudentProfile ────────────────────────────────────────────────

it('student can access the profile page', function (): void {
    $this->actingAs($this->student)
        ->get('/aluno/edit-student-profile')
        ->assertSuccessful();
});

it('non-aluno user is forbidden from profile page', function (): void {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $this->actingAs($admin)
        ->get('/aluno/edit-student-profile')
        ->assertForbidden();
});

it('student profile page shows existing profile data', function (): void {
    StudentProfile::create([
        'user_id' => $this->student->id,
        'bi_number' => 'AO001234',
        'phone' => '+244 923000000',
    ]);

    Livewire::actingAs($this->student)
        ->test(EditStudentProfile::class)
        ->assertSet('data.bi_number', 'AO001234')
        ->assertSet('data.phone', '+244 923000000');
});

it('student can save their profile', function (): void {
    Livewire::actingAs($this->student)
        ->test(EditStudentProfile::class)
        ->set('data.bi_number', 'AO007654')
        ->set('data.phone', '+244 912345678')
        ->set('data.address', 'Rua dos Coqueiros, 10')
        ->call('save')
        ->assertHasNoErrors();

    $profile = $this->student->fresh()->studentProfile;

    expect($profile)->not()->toBeNull()
        ->and($profile->bi_number)->toBe('AO007654')
        ->and($profile->phone)->toBe('+244 912345678')
        ->and($profile->address)->toBe('Rua dos Coqueiros, 10');
});

it('saving profile updates an existing student profile record', function (): void {
    StudentProfile::create([
        'user_id' => $this->student->id,
        'bi_number' => 'OLD123',
    ]);

    Livewire::actingAs($this->student)
        ->test(EditStudentProfile::class)
        ->set('data.bi_number', 'NEW456')
        ->call('save')
        ->assertHasNoErrors();

    expect(StudentProfile::where('user_id', $this->student->id)->count())->toBe(1)
        ->and($this->student->fresh()->studentProfile->bi_number)->toBe('NEW456');
});
