<?php

namespace App\Livewire;

use App\Enums\DocumentType;
use App\Enums\EnrollmentStatus;
use App\Mail\SendEnrollmentReceivedEmail;
use App\Models\Course;
use App\Models\CourseClass;
use App\Models\Enrollment;
use App\Models\EnrollmentDocument;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithFileUploads;

class EnrollmentForm extends Component
{
    use WithFileUploads;

    public Course $course;

    /** 'prompt' | 'login' | 'register' | 'form' */
    public string $authMode = 'form';

    public int $step = 1;

    public int $totalSteps = 4;

    // ── Auth fields ──────────────────────────────────────────────────────────
    public string $authEmail = '';

    public string $authPassword = '';

    public string $registerName = '';

    public string $registerEmail = '';

    public string $registerPassword = '';

    public string $registerPasswordConfirmation = '';

    // ── Step 1 — Personal info ───────────────────────────────────────────────
    public string $name = '';

    public string $email = '';

    public string $phone = '';

    public string $bi = '';

    // ── Step 2 — Documents ───────────────────────────────────────────────────
    public $biDocument = null;

    public $paymentProof = null;

    public array $otherDocuments = [];

    // ── Step 3 — Class selection ─────────────────────────────────────────────
    public ?int $courseClassId = null;

    public string $notes = '';

    // ── Final state ──────────────────────────────────────────────────────────
    public bool $submitted = false;

    public function mount(Course $course): void
    {
        $this->course = $course;

        if (Auth::check()) {
            $user = Auth::user();
            $this->name  = $user->name;
            $this->email = $user->email;
            $this->authMode = 'form';
        } else {
            $this->authMode = 'prompt';
        }
    }

    // ── Auth actions ─────────────────────────────────────────────────────────

    public function showLogin(): void
    {
        $this->authMode = 'login';
        $this->resetErrorBag();
    }

    public function showRegister(): void
    {
        $this->authMode = 'register';
        $this->resetErrorBag();
    }

    public function login(): void
    {
        $this->validate([
            'authEmail'    => 'required|email',
            'authPassword' => 'required',
        ]);

        if (Auth::attempt(['email' => $this->authEmail, 'password' => $this->authPassword])) {
            $user = Auth::user();
            $this->name  = $user->name;
            $this->email = $user->email;
            $this->authMode = 'form';
            $this->reset('authEmail', 'authPassword');
        } else {
            $this->addError('authPassword', 'Credenciais inválidas. Verifique o seu email e palavra-passe.');
        }
    }

    public function register(): void
    {
        $this->validate([
            'registerName'     => 'required|min:2|max:100',
            'registerEmail'    => 'required|email|max:100|unique:users,email',
            'registerPassword' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name'     => $this->registerName,
            'email'    => $this->registerEmail,
            'password' => Hash::make($this->registerPassword),
        ]);

        if (! $user->hasRole('aluno')) {
            $user->assignRole('aluno');
        }

        Auth::login($user);

        $this->name  = $user->name;
        $this->email = $user->email;
        $this->authMode = 'form';
        $this->reset('registerName', 'registerEmail', 'registerPassword', 'registerPasswordConfirmation');
    }

    // ── Step navigation ──────────────────────────────────────────────────────

    public function nextStep(): void
    {
        $rules = match ($this->step) {
            1 => [
                'name'  => 'required|min:2|max:100',
                'email' => 'required|email|max:100',
                'phone' => 'required|max:20',
                'bi'    => 'required|max:20',
            ],
            2 => [
                'biDocument'       => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
                'paymentProof'     => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
                'otherDocuments.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
            ],
            3 => [
                'courseClassId' => 'nullable|exists:course_classes,id',
            ],
            default => [],
        };

        $this->validate($rules);

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
            'name'             => 'required|min:2|max:100',
            'email'            => 'required|email|max:100',
            'phone'            => 'required|max:20',
            'bi'               => 'required|max:20',
            'courseClassId'    => 'nullable|exists:course_classes,id',
            'biDocument'       => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'paymentProof'     => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'otherDocuments.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
        ]);

        $user = Auth::user();

        $enrollment = Enrollment::create([
            'user_id'         => $user->id,
            'course_id'       => $this->course->id,
            'course_class_id' => $this->courseClassId,
            'status'          => EnrollmentStatus::Pendente,
            'notes'           => $this->notes ?: null,
        ]);

        $basePath = "enrollments/{$enrollment->id}";

        if ($this->biDocument) {
            $path = $this->biDocument->store($basePath, 'private');
            EnrollmentDocument::create([
                'enrollment_id' => $enrollment->id,
                'type'          => DocumentType::Bi,
                'file_path'     => $path,
                'original_name' => $this->biDocument->getClientOriginalName(),
                'mime_type'     => $this->biDocument->getMimeType(),
            ]);
        }

        if ($this->paymentProof) {
            $path = $this->paymentProof->store($basePath, 'private');
            EnrollmentDocument::create([
                'enrollment_id' => $enrollment->id,
                'type'          => DocumentType::Comprovativo,
                'file_path'     => $path,
                'original_name' => $this->paymentProof->getClientOriginalName(),
                'mime_type'     => $this->paymentProof->getMimeType(),
            ]);
        }

        foreach ($this->otherDocuments as $doc) {
            $path = $doc->store($basePath, 'private');
            EnrollmentDocument::create([
                'enrollment_id' => $enrollment->id,
                'type'          => DocumentType::Outro,
                'file_path'     => $path,
                'original_name' => $doc->getClientOriginalName(),
                'mime_type'     => $doc->getMimeType(),
            ]);
        }

        Log::channel('daily')->info('Enrollment created', [
            'enrollment_id' => $enrollment->id,
            'user_id'       => $user->id,
            'course_id'     => $this->course->id,
        ]);

        Mail::to($user->email)->queue(
            new SendEnrollmentReceivedEmail($enrollment->load(['user', 'course', 'courseClass']))
        );

        $this->submitted = true;
    }

    public function getAvailableClassesProperty(): \Illuminate\Database\Eloquent\Collection
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
