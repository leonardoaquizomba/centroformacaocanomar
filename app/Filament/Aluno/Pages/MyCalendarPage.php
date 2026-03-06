<?php

namespace App\Filament\Aluno\Pages;

use App\Enums\DayOfWeek;
use App\Models\Enrollment;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class MyCalendarPage extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static ?string $navigationLabel = 'O Meu Calendário';

    protected static string|UnitEnum|null $navigationGroup = null;

    protected static ?int $navigationSort = 3;

    protected string $view = 'filament.aluno.pages.my-calendar-page';

    public array $schedulesByDay = [];

    public function mount(): void
    {
        $schedulesByDay = [];

        foreach (DayOfWeek::cases() as $day) {
            $schedulesByDay[$day->value] = [];
        }

        $enrollments = Enrollment::query()
            ->where('user_id', Auth::id())
            ->with(['courseClass.schedules', 'courseClass.course'])
            ->whereHas('courseClass', fn ($q) => $q->where('is_active', true))
            ->get();

        foreach ($enrollments as $enrollment) {
            if (! $enrollment->courseClass) {
                continue;
            }

            foreach ($enrollment->courseClass->schedules as $schedule) {
                $schedulesByDay[$schedule->day_of_week->value][] = [
                    'course' => $enrollment->courseClass->course->name,
                    'class' => $enrollment->courseClass->name,
                    'start_time' => $schedule->start_time,
                    'end_time' => $schedule->end_time,
                    'location' => $schedule->location,
                ];
            }
        }

        $this->schedulesByDay = $schedulesByDay;
    }
}
