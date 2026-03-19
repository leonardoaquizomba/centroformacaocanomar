<?php

namespace App\Providers;

use App\Events\CertificateIssued;
use App\Events\EnrollmentApproved;
use App\Events\EnrollmentConfirmed;
use App\Events\EnrollmentRejected;
use App\Events\EnrollmentSubmitted;
use App\Events\PaymentReceived;
use App\Events\UserRegistered;
use App\Listeners\SendCertificateIssuedNotification;
use App\Listeners\SendEnrollmentApprovedNotification;
use App\Listeners\SendEnrollmentConfirmedNotification;
use App\Listeners\SendEnrollmentReceivedNotification;
use App\Listeners\SendEnrollmentRejectedNotification;
use App\Listeners\SendPaymentReceivedNotification;
use App\Listeners\SendWelcomeNotification;
use App\Models\SiteSetting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Paginator::useTailwind();

        View::composer('*', function ($view): void {
            $view->with('siteSettings', SiteSetting::get());
        });

        Event::listen(UserRegistered::class, SendWelcomeNotification::class);
        Event::listen(EnrollmentSubmitted::class, SendEnrollmentReceivedNotification::class);
        Event::listen(EnrollmentApproved::class, SendEnrollmentApprovedNotification::class);
        Event::listen(EnrollmentRejected::class, SendEnrollmentRejectedNotification::class);
        Event::listen(EnrollmentConfirmed::class, SendEnrollmentConfirmedNotification::class);
        Event::listen(PaymentReceived::class, SendPaymentReceivedNotification::class);
        Event::listen(CertificateIssued::class, SendCertificateIssuedNotification::class);
    }
}
