<?php

namespace App\Jobs;

use App\Models\Certificate;
use App\Models\Enrollment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GenerateCertificateJob implements ShouldQueue
{
    use Queueable;

    public function __construct(public Enrollment $enrollment) {}

    public function handle(): void
    {
        $enrollment = $this->enrollment->load(['user', 'course', 'courseClass']);

        $code = 'CAN-'.now()->format('Y').'-'.str_pad((string) $enrollment->id, 6, '0', STR_PAD_LEFT);

        $pdf = Pdf::loadView('pdfs.certificate', [
            'enrollment' => $enrollment,
            'code' => $code,
            'issuedAt' => now(),
        ])->setPaper('a4', 'landscape');

        $filename = 'certificates/'.Str::slug($enrollment->user->name).'-'.$code.'.pdf';

        Storage::disk('private')->put($filename, $pdf->output());

        Certificate::updateOrCreate(
            ['enrollment_id' => $enrollment->id],
            [
                'user_id' => $enrollment->user_id,
                'course_id' => $enrollment->course_id,
                'code' => $code,
                'issued_at' => now(),
                'file_path' => $filename,
            ]
        );
    }
}
