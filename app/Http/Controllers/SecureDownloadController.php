<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\EnrollmentDocument;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SecureDownloadController extends Controller
{
    public function certificate(Certificate $certificate): StreamedResponse
    {
        Gate::authorize('download', $certificate);

        abort_unless(
            $certificate->file_path && Storage::disk('private')->exists($certificate->file_path),
            404
        );

        $filename = 'certificado-'.$certificate->code.'.pdf';

        return Storage::disk('private')->download($certificate->file_path, $filename);
    }

    public function enrollmentDocument(EnrollmentDocument $document): StreamedResponse
    {
        Gate::authorize('download', $document);

        abort_unless(
            $document->file_path && Storage::disk('private')->exists($document->file_path),
            404
        );

        return Storage::disk('private')->download($document->file_path, $document->original_name ?? basename($document->file_path));
    }
}
