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
                $avgScore = $grades->isNotEmpty() ? round($grades->avg('score'), 1) : null;
                $avgMaxScore = $grades->isNotEmpty() ? round($grades->avg('max_score'), 1) : null;

                $attendancePct = $total > 0 ? (int) round(($present + $late) / $total * 100) : null;

                return [
                    'name' => $enrollment->user->name,
                    'enrollment_status' => $enrollment->status->getLabel(),
                    'enrollment_status_class' => $this->statusBadgeClass($enrollment->status->getColor()),
                    'total_sessions' => $total,
                    'present' => $present,
                    'absent' => $absent,
                    'late' => $late,
                    'justified' => $justified,
                    'attendance_pct' => $attendancePct,
                    'grade_count' => $grades->count(),
                    'grade_avg' => $avgScore,
                    'grade_avg_max' => $avgMaxScore,
                ];
            })
            ->sortBy('name')
            ->values()
            ->all();

        $reports = collect($this->studentReports);
        $attendancePcts = $reports->pluck('attendance_pct')->filter();
        $studentsWithGrades = $reports->filter(fn ($s) => $s['grade_avg'] !== null);

        $this->classInfo['class_avg_attendance'] = $attendancePcts->isNotEmpty()
            ? (int) round($attendancePcts->avg())
            : null;
        $this->classInfo['class_avg_grade'] = $studentsWithGrades->isNotEmpty()
            ? round($studentsWithGrades->avg('grade_avg'), 1)
            : null;
        $this->classInfo['class_avg_grade_max'] = $studentsWithGrades->isNotEmpty()
            ? round($studentsWithGrades->avg('grade_avg_max'), 1)
            : null;
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

    private function statusBadgeClass(string|array|null $color): string
    {
        return match ($color) {
            'warning' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
            'info' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
            'success' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
            'danger' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
            default => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300',
        };
    }
}
