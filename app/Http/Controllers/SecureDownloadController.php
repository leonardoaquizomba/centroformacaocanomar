<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\EnrollmentDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SecureDownloadController extends Controller
{
    public function certificate(Request $request, Certificate $certificate): StreamedResponse
    {
        abort_unless(
            $request->user()?->id === $certificate->user_id || $request->user()?->hasRole('admin'),
            403
        );

        abort_unless(
            $certificate->file_path && Storage::disk('private')->exists($certificate->file_path),
            404
        );

        $filename = 'certificado-'.$certificate->code.'.pdf';

        return Storage::disk('private')->download($certificate->file_path, $filename);
    }

    public function enrollmentDocument(Request $request, EnrollmentDocument $document): StreamedResponse
    {
        abort_unless(
            $request->user()?->id === $document->enrollment->user_id || $request->user()?->hasRole('admin'),
            403
        );

        abort_unless(
            $document->file_path && Storage::disk('private')->exists($document->file_path),
            404
        );

        return Storage::disk('private')->download($document->file_path, $document->original_name ?? basename($document->file_path));
    }
}
