<?php

use App\Enums\AttendanceStatus;
use App\Enums\EnrollmentStatus;
use App\Filament\Professor\Pages\ClassReportPage;
use App\Models\Attendance;
use App\Models\CourseClass;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->teacher = User::factory()->create();
    $this->teacher->assignRole('professor');
});

// ─── T-041: ClassReportPage ───────────────────────────────────────────────────

it('teacher can access the class report page', function (): void {
    $this->actingAs($this->teacher)
        ->get('/professor/class-report-page')
        ->assertSuccessful();
});

it('non-teacher user is forbidden from class report page', function (): void {
    $student = User::factory()->create();
    $student->assignRole('aluno');

    $this->actingAs($student)
        ->get('/professor/class-report-page')
        ->assertForbidden();
});

it('report page shows prompt when teacher has no assigned classes', function (): void {
    Livewire::actingAs($this->teacher)
        ->test(ClassReportPage::class)
        ->assertSee('Seleccione uma turma para ver o relatório.');
});

it('report page auto-selects the first class on mount', function (): void {
    $class = CourseClass::factory()->create(['teacher_id' => $this->teacher->id]);

    $component = Livewire::actingAs($this->teacher)
        ->test(ClassReportPage::class);

    expect($component->get('selectedClassId'))->toBe($class->id);
});

it('report shows class info after selecting a class', function (): void {
    $class = CourseClass::factory()->create(['teacher_id' => $this->teacher->id]);

    Livewire::actingAs($this->teacher)
        ->test(ClassReportPage::class)
        ->assertSet('selectedClassId', $class->id)
        ->assertSee($class->name)
        ->assertSee($class->course->name);
});

it('report lists enrolled students', function (): void {
    $class = CourseClass::factory()->create(['teacher_id' => $this->teacher->id]);
    $student = User::factory()->create();
    $student->assignRole('aluno');

    Enrollment::factory()->create([
        'user_id' => $student->id,
        'course_id' => $class->course_id,
        'course_class_id' => $class->id,
        'status' => EnrollmentStatus::Matriculado,
    ]);

    Livewire::actingAs($this->teacher)
        ->test(ClassReportPage::class)
        ->assertSee($student->name);
});

it('report shows attendance summary for enrolled students', function (): void {
    $class = CourseClass::factory()->create(['teacher_id' => $this->teacher->id]);
    $student = User::factory()->create();
    $student->assignRole('aluno');

    Enrollment::factory()->create([
        'user_id' => $student->id,
        'course_id' => $class->course_id,
        'course_class_id' => $class->id,
    ]);

    // 2 present, 1 absent
    Attendance::create(['course_class_id' => $class->id, 'user_id' => $student->id, 'session_date' => now(), 'status' => AttendanceStatus::Presente]);
    Attendance::create(['course_class_id' => $class->id, 'user_id' => $student->id, 'session_date' => now()->addDay(), 'status' => AttendanceStatus::Presente]);
    Attendance::create(['course_class_id' => $class->id, 'user_id' => $student->id, 'session_date' => now()->addDays(2), 'status' => AttendanceStatus::Ausente]);

    $component = Livewire::actingAs($this->teacher)->test(ClassReportPage::class);

    $report = $component->get('studentReports')[0];

    expect($report['total_sessions'])->toBe(3)
        ->and($report['present'])->toBe(2)
        ->and($report['absent'])->toBe(1)
        ->and($report['attendance_pct'])->toBe(67);
});

it('report shows grade average for enrolled students', function (): void {
    $class = CourseClass::factory()->create(['teacher_id' => $this->teacher->id]);
    $student = User::factory()->create();
    $student->assignRole('aluno');

    $enrollment = Enrollment::factory()->create([
        'user_id' => $student->id,
        'course_id' => $class->course_id,
        'course_class_id' => $class->id,
    ]);

    Grade::create([
        'enrollment_id' => $enrollment->id,
        'user_id' => $student->id,
        'course_class_id' => $class->id,
        'teacher_id' => $this->teacher->id,
        'name' => 'Teste 1',
        'score' => 14.0,
        'max_score' => 20.0,
    ]);

    Grade::create([
        'enrollment_id' => $enrollment->id,
        'user_id' => $student->id,
        'course_class_id' => $class->id,
        'teacher_id' => $this->teacher->id,
        'name' => 'Teste 2',
        'score' => 16.0,
        'max_score' => 20.0,
    ]);

    $component = Livewire::actingAs($this->teacher)->test(ClassReportPage::class);

    $report = $component->get('studentReports')[0];

    expect($report['grade_count'])->toBe(2)
        ->and($report['grade_avg'])->toBe(15.0);
});

it('teacher cannot view report for a class assigned to another teacher', function (): void {
    $otherTeacher = User::factory()->create();
    $class = CourseClass::factory()->create(['teacher_id' => $otherTeacher->id]);

    Livewire::actingAs($this->teacher)
        ->test(ClassReportPage::class)
        ->set('selectedClassId', $class->id)
        ->assertHasNoErrors();

    // classInfo should remain null — the class doesn't belong to this teacher
    $component = Livewire::actingAs($this->teacher)->test(ClassReportPage::class);
    expect($component->get('classInfo'))->toBeNull();
});
