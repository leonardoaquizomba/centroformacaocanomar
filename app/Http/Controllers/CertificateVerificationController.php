<?php

namespace App\Http\Controllers;

use App\Http\Requests\VerifyCertificateRequest;
use App\Models\Certificate;
use Illuminate\Support\Facades\Log;

class CertificateVerificationController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        return view('pages.certificate-verify');
    }

    public function verify(VerifyCertificateRequest $request): \Illuminate\Http\JsonResponse
    {

        $code = strtoupper(trim($request->code));

        $certificate = Certificate::query()
            ->with(['user', 'course'])
            ->where('code', $code)
            ->first();

        if (! $certificate) {
            Log::channel('daily')->warning('Certificate verification failed', [
                'code' => $code,
                'ip' => $request->ip(),
            ]);

            return response()->json(['found' => false]);
        }

        Log::channel('daily')->info('Certificate verified', [
            'code' => $certificate->code,
            'ip' => $request->ip(),
        ]);

        return response()->json([
            'found' => true,
            'code' => $certificate->code,
            'student' => $certificate->user->name,
            'course' => $certificate->course->name,
            'issued_at' => $certificate->issued_at?->format('d/m/Y'),
        ]);
    }
}
