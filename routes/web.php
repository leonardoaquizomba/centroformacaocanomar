<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CertificateVerificationController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\SecureDownloadController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/cursos', [CoursesController::class, 'index'])->name('courses.index');
Route::get('/cursos/{slug}', [CoursesController::class, 'show'])->name('courses.show');

Route::get('/sobre', [AboutController::class, 'index'])->name('about');

Route::get('/contactos', [ContactController::class, 'index'])->name('contact');

Route::get('/noticias', [BlogController::class, 'index'])->name('blog.index');
Route::get('/noticias/{slug}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/verificar-certificado', [CertificateVerificationController::class, 'index'])->name('certificate.verify');
Route::post('/verificar-certificado', [CertificateVerificationController::class, 'verify'])->name('certificate.verify.check')->middleware('throttle:5,1');

// Signed URL — prevents token tampering; generated via URL::signedRoute() in SendNewsletterWelcomeEmail.
Route::get('/newsletter/unsubscribe/{token}', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe')->middleware(['signed', 'throttle:10,1']);

Route::get('/login', fn () => redirect('/admin/login'))->name('login');

Route::middleware('auth')->group(function (): void {
    Route::get('/download/certificado/{certificate}', [SecureDownloadController::class, 'certificate'])->name('download.certificate');
    Route::get('/download/documento/{document}', [SecureDownloadController::class, 'enrollmentDocument'])->name('download.document');
});
