<?php

namespace App\Http\Controllers;

use App\Http\Requests\VerifyCertificateRequest;
use App\Models\Certificate;

class CertificateVerificationController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        return view('pages.certificate-verify');
    }

    public function verify(VerifyCertificateRequest $request): \Illuminate\Http\JsonResponse
    {

        $certificate = Certificate::query()
            ->with(['user', 'course'])
            ->where('code', strtoupper(trim($request->code)))
            ->first();

        if (! $certificate) {
            return response()->json(['found' => false]);
        }

        return response()->json([
            'found' => true,
            'code' => $certificate->code,
            'student' => $certificate->user->name,
            'course' => $certificate->course->name,
            'issued_at' => $certificate->issued_at?->format('d/m/Y'),
        ]);
    }
}
