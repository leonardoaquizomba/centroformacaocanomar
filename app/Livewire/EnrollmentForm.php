<?php

namespace App\Livewire;

use App\Mail\SendEnrollmentReceivedEmail;
use App\Models\Course;
use App\Models\CourseClass;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Validate;
use Livewire\Component;

class EnrollmentForm extends Component
{
    public Course $course;

    public int $step = 1;

    public int $totalSteps = 3;

    // Step 1 — Personal info
    #[Validate('required|min:2|max:100')]
    public string $name = '';

    #[Validate('required|email|max:100')]
    public string $email = '';

    #[Validate('required|max:20')]
    public string $phone = '';

    #[Validate('nullable|max:20')]
    public string $bi = '';

    // Step 2 — Course options
    #[Validate('nullable|exists:course_classes,id')]
    public ?int $courseClassId = null;

    public string $notes = '';

    // Step 3 — Confirmation
    public bool $submitted = false;

    public function mount(Course $course): void
    {
        $this->course = $course;
    }

    public function nextStep(): void
    {
        $rules = match ($this->step) {
            1 => ['name', 'email', 'phone', 'bi'],
            2 => ['courseClassId'],
            default => [],
        };

        $this->validateOnly(implode(',', $rules));

        if ($this->step < $this->totalSteps) {
            $this->step++;
        }
    }

    public function prevStep(): void
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    public function submit(): void
    {
        $this->validate([
            'name' => 'required|min:2|max:100',
            'email' => 'required|email|max:100',
            'phone' => 'required|max:20',
            'courseClassId' => 'nullable|exists:course_classes,id',
        ]);

        // Create or find user by email
        $user = \App\Models\User::firstOrCreate(
            ['email' => $this->email],
            ['name' => $this->name, 'password' => bcrypt(\Illuminate\Support\Str::random(16))]
        );

        // Assign aluno role if not yet assigned
        if (! $user->hasRole('aluno')) {
            $user->assignRole('aluno');
        }

        // Create enrollment
        $enrollment = Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $this->course->id,
            'course_class_id' => $this->courseClassId,
            'status' => 'pendente',
            'notes' => $this->notes ?: null,
        ]);

        Mail::to($user->email)->queue(new SendEnrollmentReceivedEmail($enrollment->load(['user', 'course', 'courseClass'])));

        $this->submitted = true;
    }

    public function getAvailableClassesProperty()
    {
        return CourseClass::query()
            ->where('course_id', $this->course->id)
            ->where('is_active', true)
            ->get();
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.enrollment-form');
    }
}
