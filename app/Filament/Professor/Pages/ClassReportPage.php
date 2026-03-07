<?php

namespace App\Filament\Professor\Pages;

use App\Enums\AttendanceStatus;
use App\Models\Attendance;
use App\Models\CourseClass;
use App\Models\Grade;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class ClassReportPage extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;

    protected static ?string $navigationLabel = 'Relatório de Turma';

    protected static string|UnitEnum|null $navigationGroup = null;

    protected static ?int $navigationSort = 5;

    protected string $view = 'filament.professor.pages.class-report-page';

    public ?int $selectedClassId = null;

    /** @var array<string, mixed>|null */
    public ?array $classInfo = null;

    /** @var list<array<string, mixed>> */
    public array $studentReports = [];

    public function mount(): void
    {
        $first = CourseClass::query()
            ->where('teacher_id', Auth::id())
            ->orderByDesc('start_date')
            ->first();

        if ($first) {
            $this->selectedClassId = $first->id;
            $this->loadReport();
        }
    }

    public function updatedSelectedClassId(): void
    {
        $this->loadReport();
    }

    private function loadReport(): void
    {
        if (! $this->selectedClassId) {
            $this->classInfo = null;
            $this->studentReports = [];

            return;
        }

        $courseClass = CourseClass::query()
            ->where('id', $this->selectedClassId)
            ->where('teacher_id', Auth::id())
            ->with(['course', 'enrollments.user', 'schedules'])
            ->first();

        if (! $courseClass) {
            $this->classInfo = null;
            $this->studentReports = [];

            return;
        }

        $this->classInfo = [
            'course_name' => $courseClass->course->name,
            'class_name' => $courseClass->name,
            'start_date' => $courseClass->start_date->format('d/m/Y'),
            'end_date' => $courseClass->end_date->format('d/m/Y'),
            'is_active' => $courseClass->is_active,
            'total_slots' => $courseClass->max_students,
            'enrolled' => $courseClass->enrollments->count(),
        ];

        $userIds = $courseClass->enrollments->pluck('user_id');

        $attendancesByUser = Attendance::query()
            ->where('course_class_id', $this->selectedClassId)
            ->whereIn('user_id', $userIds)
            ->get()
            ->groupBy('user_id');

        $gradesByUser = Grade::query()
            ->where('course_class_id', $this->selectedClassId)
            ->whereIn('user_id', $userIds)
            ->get()
            ->groupBy('user_id');

        $this->studentReports = $courseClass->enrollments
            ->map(function ($enrollment) use ($attendancesByUser, $gradesByUser) {
                $uid = $enrollment->user_id;
                $attendances = $attendancesByUser->get($uid, collect());
                $total = $attendances->count();

                $present = $attendances->where('status', AttendanceStatus::Presente)->count();
                $absent = $attendances->where('status', AttendanceStatus::Ausente)->count();
                $late = $attendances->where('status', AttendanceStatus::Atrasado)->count();
                $justified = $attendances->where('status', AttendanceStatus::Justificado)->count();

                $grades = $gradesByUser->get($uid, collect());
                $avgScore = $grades->count() > 0
                    ? round($grades->avg('score'), 1)
                    : null;

                return [
                    'name' => $enrollment->user->name,
                    'enrollment_status' => $enrollment->status->getLabel(),
                    'total_sessions' => $total,
                    'present' => $present,
                    'absent' => $absent,
                    'late' => $late,
                    'justified' => $justified,
                    'attendance_pct' => $total > 0 ? (int) round(($present + $late) / $total * 100) : null,
                    'grade_count' => $grades->count(),
                    'grade_avg' => $avgScore,
                ];
            })
            ->sortBy('name')
            ->values()
            ->all();
    }

    /** @return array<int, string> */
    public function getClassOptions(): array
    {
        return CourseClass::query()
            ->where('teacher_id', Auth::id())
            ->with('course')
            ->orderByDesc('start_date')
            ->get()
            ->mapWithKeys(fn ($c) => [$c->id => "{$c->course->name} – {$c->name}"])
            ->all();
    }
}
