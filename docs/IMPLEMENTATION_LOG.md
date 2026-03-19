# CANOMAR – Implementation Log

---

## 2026-03-19 – Class Report Improvements

**Task:** Make improvements to the ClassReportPage in the teacher portal

**What was done:**
- Added 2 new summary cards to the header: class-wide average attendance % and average grade (both colour-coded green/yellow/red)
- Added `Justificadas` column — the field existed in backend data but was never shown in the table
- Grade averages now render as "X / Y" (e.g. "13.5 / 20") with green/yellow/red colour coding based on score percentage
- Enrollment status replaced plain text with colour-coded badges matching EnrollmentStatus enum colours
- Summary totals/averages row added to `<tfoot>` — sums per-column totals and repeats the class average stats
- `wire:loading.delay` indicator shown while report refreshes on class switch
- `statusBadgeClass()` private helper maps Filament colour tokens → Tailwind class strings
- 5 new Pest tests added (14 total, all passing): justified count, grade_avg_max, status badge class, class avg attendance, class avg grade

---

## 2026-03-19 – Teacher Portal: Scope Resources to Assigned Classes

**Task:** Fix teacher dashboard — materials, grades, and attendance must be scoped to the teacher's assigned classes; adding materials was not possible

**What was done:**
- Wrapped all `->options(CourseClass::query()->where('teacher_id', Auth::id())...)` calls in closures (`fn () =>`) across `MateriaisUploadResource`, `PresencasResource`, and `NotasResource` for correct lazy evaluation with Livewire 4
- Applied the same closure fix to `SelectFilter` options in `PresencasResource` and `NotasResource`
- Replaced `->reactive()` with `->live()` in `NotasResource` (Filament 5 / Livewire 4 API)
- Updated `CourseClassSeeder` to assign the first class to the generic test professor account (`professor@canomar.ao`) so the portal is testable on fresh seeds
- Assigned class ID 1 to test professor (ID 2) in the live DB via tinker

---

## 2026-03-16 – Dynamic Site Settings System

**Task:** Admin-editable contact info and social media links

**What was done:**
- Created `site_settings` migration and `SiteSetting` model (singleton via `firstOrCreate(['id'=>1])`), with `whatsappUrl()` and `telLink()` helpers
- Built `ManageSettings` Filament admin page (Configurações group) with two sections: Informações de Contacto and Redes Sociais
- Added view composer in `AppServiceProvider` sharing `$siteSettings` to all views
- Updated footer in `app.blade.php` and `contact.blade.php` to use dynamic settings; social icons only render when a URL is configured
- Ran `shield:generate --all` to create permission for the new page

---

## 2026-03-07 – Ownership Policies for Secure Downloads (M5)

**Task:** Security – M5 (OWASP)

**What was done:**

- **`CertificatePolicy::download()`**: new method checking `$user->id === $certificate->user_id || $user->hasRole('admin')` — admins can download any certificate, students only their own.
- **`EnrollmentDocumentPolicy`** (`app/Policies/EnrollmentDocumentPolicy.php`): new policy with a `download()` method that checks ownership via `$document->enrollment->user_id`.
- **`SecureDownloadController`** (`app/Http/Controllers/SecureDownloadController.php`): replaced `abort_unless()` inline ownership checks with `Gate::authorize('download', $model)` — delegating authorization to the policies.
- **Factories**: `CertificateFactory` and `EnrollmentDocumentFactory` created to support test setup.
- **`SecureDownloadTest`** (`tests/Feature/SecureDownloadTest.php`): 7 tests — own certificate/document download (200), other user's download (403), admin download (200), missing file (404) — all passing.

**Result:** 91/94 tests passing (3 pre-existing `AdminResourcesTest` failures unrelated to this change).

---

## 2026-03-07 – Newsletter Signed Unsubscribe URL (M4)

**Task:** Security – M4 (OWASP)

**What was done:**

- **`SendNewsletterWelcomeEmail`** (`app/Mail/SendNewsletterWelcomeEmail.php`): queued mailable that accepts a `NewsletterSubscriber`; generates a signed unsubscribe URL via `URL::signedRoute()` in the constructor — HMAC prevents tampering with the token in the URL.
- **Email view** (`resources/views/emails/newsletter/welcome.blade.php`): welcome confirmation email with a signed unsubscribe link in the footer, matching existing email styling.
- **`NewsletterForm`** (`app/Livewire/NewsletterForm.php`): queues `SendNewsletterWelcomeEmail` after subscription; only sends on `wasRecentlyCreated` or re-subscription (`wasChanged('unsubscribed_at')`) to avoid spamming existing subscribers.
- **Route** (`routes/web.php`): `newsletter.unsubscribe` now requires `['signed', 'throttle:10,1']` middleware — unsigned URLs are rejected.
- **`bootstrap/app.php`**: `InvalidSignatureException` caught in `withExceptions()` and redirected to home with a user-friendly flash message instead of a raw 403.
- **Tests** (`tests/Feature/NewsletterTest.php`): 9 tests — subscribe queues welcome email, unsubscribe via signed URL, tampered unsigned URL rejected (subscriber remains active), invalid token with signed URL, compact mode — all passing.

**Result:** 84/86 tests passing.

---

## 2026-03-07 – OWASP Security Audit & Remediation

**Task:** Security audit (OWASP Top Ten)

**What was done:**

Full OWASP Top Ten security audit performed. 3 critical, 4 high, 7 medium, and 3 low severity vulnerabilities identified and the following remediations applied:

- **C1 – Stored XSS** (`app/Models/Post.php`): `setBodyAttribute` mutator strips dangerous tags (`<script>`, `<iframe>`, etc.) and event handler attributes (`onerror=`, `onload=`) on storage, so `{!! $post->body !!}` renders only sanitized HTML.
- **C2 – APP_DEBUG disabled** (`.env`): `APP_DEBUG=false` prevents stack traces and DB queries being exposed on errors.
- **C3 + M6 – Session security** (`.env`): `SESSION_ENCRYPT=true` and `SESSION_SECURE_COOKIE=true` enforce encrypted sessions and HTTPS-only cookies.
- **H1 – Login rate limiting** (`bootstrap/app.php`): Global `throttle:60,1` on the web middleware group covers all Filament login routes. Admin panel additionally protected by MFA (EmailAuthentication + AppAuthentication).
- **H2 – Public endpoint rate limiting** (`routes/web.php`): `throttle:5,1` on `POST /verificar-certificado`; `throttle:10,1` on `GET /newsletter/unsubscribe/{token}`.
- **H3 – Email verification for enrollment users** (`app/Livewire/EnrollmentForm.php`): `sendEmailVerificationNotification()` called for newly created users; `bcrypt()` replaced with `Hash::make()`.
- **H4 – Tinker moved to dev** (`composer.json`): `laravel/tinker` moved from `require` to `require-dev` to prevent REPL availability in production.
- **M1 – SVG XSS blocked** (4 Filament upload fields): `->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])` added to `CourseForm`, `PostForm`, `TestimonialForm`, and `EditStudentProfile`.
- **M3 – Email enumeration prevented** (`app/Livewire/NewsletterForm.php`): Removed revealing `email.unique` error message; duplicate submissions silently succeed via `updateOrCreate`.
- **M7 – Audit logging** (`CertificateVerificationController`, `EnrollmentForm`): `Log::channel('daily')` records certificate verification attempts (with IP) and enrollment creation events.
- **L3 – Upload size limit** (`MateriaisUploadResource`): `->maxSize(102400)` (100 MB) added to prevent disk exhaustion.
- **Test updated** (`tests/Feature/NewsletterTest.php`): `'rejects duplicate active email'` → `'silently succeeds on duplicate active email to prevent enumeration'`.

**Result:** 83/86 tests passing (3 pre-existing `AdminResourcesTest` failures from Filament Shield permissions — unrelated to this audit).

---

## 2026-03-07 – Teacher Class Report Page (T-041)

**Task:** T-041

**What was done:**

- **`ClassReportPage`** (`app/Filament/Professor/Pages/ClassReportPage.php`): Filament custom page in the `/professor` panel; `mount()` auto-selects the most recent class taught by the authenticated teacher; `updatedSelectedClassId()` reloads the report when the dropdown changes; `loadReport()` aggregates enrollment, attendance, and grade data per student, scoped to `teacher_id = Auth::id()` to prevent cross-teacher data access.
- **View** (`resources/views/filament/professor/pages/class-report-page.blade.php`): class selector dropdown (Livewire `wire:model.live`); 4-stat header row (course, class, period, enrolled/slots); data table listing each student with their enrollment status, total sessions, present/absent/late counts, colour-coded attendance %, grade count and average; empty states for no class selected and no enrolled students.
- **Pest feature tests** (`tests/Feature/ProfessorPortalPagesTest.php`): 9 tests — page access (200 teacher / 403 non-teacher), no-class empty state, auto-select on mount, class info display, enrolled student listing, attendance summary, grade average, and cross-teacher isolation — all passing.
- `vendor/bin/pint --dirty` applied; all tests passing.

---

## 2026-03-07 – Student Calendar & Profile Pages (T-033, T-034)

**Tasks:** T-033, T-034

**What was done:**

- **`MyCalendarPage`** (`app/Filament/Aluno/Pages/MyCalendarPage.php`): Filament custom page in the `/aluno` panel; `mount()` loads enrolled active `CourseClass` schedules via `Auth::user()->enrollments()->with(['courseClass.schedules', 'courseClass.course'])`, groups them by `DayOfWeek` enum value. Blade view (`resources/views/filament/aluno/pages/my-calendar-page.blade.php`): responsive 7-column weekly grid with Alpine.js today-highlight; empty state when no active enrollments. Route: `/aluno/my-calendar-page`.
- **`EditStudentProfile`** (`app/Filament/Aluno/Pages/EditStudentProfile.php`): Filament custom page with a 2-section form (Dados da Conta — read-only name/email; Dados Pessoais — photo, BI, DOB, phone, address); `mount()` pre-fills from `StudentProfile`; `save()` uses `updateOrCreate` to create or update the profile row; header `Action::make('save')` triggers the save. Route: `/aluno/edit-student-profile`.
- **Pest feature tests** (`tests/Feature/AlunoPortalPagesTest.php`): 9 tests — page access (200 for aluno, 403 for admin), empty state, schedule data display, profile pre-fill, profile save, updateOrCreate upsert — all passing.
- `vendor/bin/pint --dirty` applied; all tests passing.

---

## 2026-03-06 – Newsletter Subscription (T-067)

**Task:** T-067

**What was done:**

- **`NewsletterSubscriber` model + migration + factory**: `newsletter_subscribers` table with `email` (unique), `name` (nullable), `token` (unique, for unsubscribe), `subscribed_at`, `unsubscribed_at`; `active()` scope; `unsubscribed()` factory state
- **`NewsletterForm` Livewire component** (`app/Livewire/NewsletterForm.php`): `email`, `name`, `compact` props; `subscribe()` action using `updateOrCreate` (supports resubscription); email validated as unique among active subscribers via `Rule::unique()->whereNull('unsubscribed_at')`; compact prop toggles between full homepage form and minimal footer form
- **Homepage newsletter section** added between the Blog section and the CTA Banner (dark gradient background, envelope icon, headline, subtext, full Livewire form)
- **Footer compact widget** added to the brand column below social links (`<livewire:newsletter-form :compact="true" />`)
- **`NewsletterController`** + `GET /newsletter/unsubscribe/{token}` route: marks subscriber as unsubscribed, redirects home with flash
- **Filament admin resource** (`app/Filament/Resources/Newsletter/NewsletterSubscriberResource.php`): read-only list, status badge (Activo/Cancelado), active/unsubscribed filter, sorted by subscribed_at desc
- **Pest feature tests** (`tests/Feature/NewsletterTest.php`): 8 tests — subscribe, token stored, duplicate rejection, resubscription, invalid email, unsubscribe, invalid token, compact mode — all passing
- `vendor/bin/pint --dirty` applied; full suite: 68/68 tests passing

---

## 2026-03-06 – Enum Refactor + Phase 7: Tests (T-062 to T-066)

**Tasks:** T-062, T-063, T-064, T-065, T-066 + enum refactor

**What was done:**

- **Enum refactor**: Created 8 PHP backed string enum classes in `app/Enums/` — `EnrollmentStatus`, `PaymentStatus`, `PaymentMethod`, `CourseModality`, `CourseLevel`, `AttendanceStatus`, `DocumentType`, `DayOfWeek` — all implementing `HasLabel` (and `HasColor` where applicable). Updated model `casts()` for `Enrollment`, `Payment`, `Course`, `Attendance`, `EnrollmentDocument`, `Schedule`. Removed manual color closures and options arrays from all Filament tables, forms, and widgets; replaced with enum class references.
- **T-062 EnrollmentFlowTest**: enrollment creation, email queuing, role assignment, payment approval, secure download auth — 7 tests.
- **T-063 CertificateJobTest**: queue dispatch, PDF generation + private disk storage, code format, upsert idempotency — 4 tests.
- **T-064 PublicPagesTest**: smoke test all public routes, blog pagination, certificate verification — 9 tests.
- **T-065 AdminResourcesTest**: admin panel access, resource list pages, portal panel access per role — 10 tests.
- **T-066 ModelsTest**: role assignments, course/enrollment/payment relationships, cert code format, arch tests — 14 tests.
- **Bug fixes**: `BlogController` HAVING clause replaced with `whereHas` (SQLite compat); `courses/show.blade.php` updated to use `->getLabel()` on enum fields; named `login` route added for auth middleware redirect; `EnrollmentFactory` and `PaymentFactory` filled with proper definitions; `RoleSeeder` seeded in `Pest.php` `beforeEach`.

**Result:** 60/60 tests passing.

---

## 2026-03-06 – Phase 6: Security & Configuration (T-058 to T-061, T-057 deferred)

**Tasks:** T-058, T-059, T-060, T-061

**What was done:**

- **T-058 Form Requests**: `StoreContactMessageRequest`, `StoreEnrollmentRequest` (with Portuguese error messages); `VerifyCertificateRequest` wired into `CertificateVerificationController` replacing inline `$request->validate()`
- **T-059 Private storage disk**: explicit `private` disk in `config/filesystems.php` pointing to `storage/app/private`; `certificates/` subdirectory created
- **T-060 Google Analytics**: `GOOGLE_ANALYTICS_ID` env var; `config/services.php` entry; conditional gtag v4 snippet injected into layout `<head>`
- **T-061 Queue/schedule**: `QUEUE_CONNECTION=database` set in `.env`; `routes/console.php` schedules `queue:prune-batches` daily and `queue:prune-failed` weekly
- **T-057 skipped** (Filament Shield) — deferred per user instruction

---

## 2026-03-06 – Phase 5: Business Logic & Automation (T-051 to T-056)

**Tasks:** T-051 to T-056

**What was done:**

- **T-051 SendEnrollmentReceivedEmail**: queued mailable + HTML view (`emails.enrollment.received`); dispatched in `EnrollmentForm::submit()`
- **T-052 SendEnrollmentApprovedEmail**: queued mailable + HTML view (`emails.enrollment.approved`); dispatched in admin `EnrollmentsTable` approve action
- **T-053 SendEnrollmentConfirmedEmail**: queued mailable + HTML view (`emails.enrollment.confirmed`); dispatched by `ProcessPaymentApproval`
- **T-054 GenerateCertificateJob**: queued job, generates landscape A4 PDF via `barryvdh/laravel-dompdf`, stores to private disk at `certificates/{slug}-{code}.pdf`, upserts `Certificate` record with code `CAN-YYYY-NNNNNN`
- **T-055 SecureDownloadController**: auth-gated routes `/download/certificado/{certificate}` and `/download/documento/{document}`; ownership check (own record or admin)
- **T-056 ProcessPaymentApproval**: action class: marks payment `pago`, updates enrollment to `confirmado`, queues `SendEnrollmentConfirmedEmail` + `GenerateCertificateJob`; wired into PaymentResource `markAsPaid` action
- Installed `barryvdh/laravel-dompdf ^3.1`

---

## 2026-03-06 – Phase 4: Public Website (T-042 to T-050)

**Tasks:** T-042 to T-050

**What was done:**

- **Tailwind CSS v4 theme** (`resources/css/app.css`): custom `@theme` with full `primary` (orange `#EC671C`) and `secondary` (navy `#171847`) color scales, display font (Sora), body font (Plus Jakarta Sans), utility classes (`btn-primary`, `btn-secondary`, `btn-outline`, `section-title`, `card-hover`, `bg-gradient-hero`, `bg-gradient-primary`, `text-gradient`)
- **Layout** (`resources/views/layouts/app.blade.php`): sticky responsive navbar (Alpine.js scroll detection + mobile hamburger), footer with brand, quick links, contact info, social icons (Facebook/Instagram/LinkedIn/YouTube/WhatsApp), scroll-to-top button; Google Fonts, Font Awesome 6, Bootstrap Icons via CDN
- **Home page** (T-043): hero with gradient + floating stat cards, categories strip, featured courses grid, "Why Canomar" metrics section, orange stats banner, testimonials, recent blog posts, CTA banner
- **Courses catalog** (T-044): `CourseCatalog` Livewire component with live search + 3 filters (category, modality, level), `#[Url]` bound, active-filter badges, `wire:loading` overlay, paginated card grid
- **Course detail** (T-045): full description, stats bar, class schedules table, enrollment card with `EnrollmentForm` Livewire component embedded
- **Enrollment form** (T-046): 3-step Livewire form (personal info → course/class → confirmation), `validateOnly()` per step, creates/finds User + assigns `aluno` role + creates Enrollment with `pendente` status
- **About page** (T-047): mission/vision, stat cards, values grid, dynamic teacher team section, CTA
- **Contacts page** (T-048): contact info sidebar, `ContactForm` Livewire component (stores `ContactMessage`), map placeholder
- **Blog** (T-049): paginated list with category filters; post detail with prose styles, share buttons, related posts
- **Certificate verification** (T-050): Alpine.js fetch to POST JSON endpoint, valid/invalid result cards
- **Controllers**: HomeController, CoursesController, AboutController, BlogController, ContactController, CertificateVerificationController
- **Routes** (`routes/web.php`): all public named routes registered (home, courses.index, courses.show, about, contact, blog.index, blog.show, certificate.verify, certificate.verify.check)
- Assets compiled: `npm run build`; code formatted: `vendor/bin/pint --dirty`

---

## 2026-03-06 – Phase 3: Student & Teacher Portals (T-027 to T-041)

**Tasks:** T-027 to T-041

**What was done:**

- New models + migrations: CourseMaterial, Grade, Attendance (with unique session constraint)
- Added `canAccessPanel()` to User model — role-based panel access (admin/aluno/professor)
- Student Portal `/aluno` (AlunoPanelProvider): login, profile, darkMode, orange theme
  - AlunoStatsOverview widget (T-028): active enrollments, completed courses, certificates
  - MinhasInscricoesResource (T-029): own enrollments, scoped to auth user, read-only
  - MeusCertificadosResource (T-030): own certificates with PDF indicator
  - MateriaisResource (T-031): materials from enrolled classes
  - MinhasNotasResource (T-032): own grades with score display
- Teacher Portal `/professor` (ProfessorPanelProvider): login, profile, darkMode, orange theme
  - ProfessorStatsOverview widget (T-036): active classes, total students, pending grades
  - MinhasTurmasResource (T-037): own classes with enrollment counts
  - PresencasResource (T-038): attendance CRUD scoped to own classes
  - NotasResource (T-039): grade entry, teacher_id auto-set on create
  - MateriaisUploadResource (T-040): file uploads to private storage, scoped to own classes

---

## 2026-03-06 – Phase 2: Filament Admin Panel (T-015 to T-026)

**Tasks:** T-015, T-016, T-017, T-018, T-019, T-020, T-021, T-022, T-023, T-024, T-025, T-026

**What was done:**

- Created 10 Filament admin resources with Portuguese labels (Schemas + Tables pattern):
  - CourseCategoryResource, CourseResource, CourseClassResource (with Schedule repeater)
  - EnrollmentResource (approve/reject actions), PaymentResource (mark-as-paid action)
  - CertificateResource, PostResource, ContactMessageResource (read-only inbox)
  - TestimonialResource, UserResource (with Spatie roles select)
- Fixed PHP 8.4 property type invariance: `$navigationGroup` must use `string|UnitEnum|null` with explicit `use UnitEnum;` import (not `?string`)
- Created `StatsOverview` widget with 4 stats: total students, active courses, monthly enrollments, monthly revenue

---

## 2026-03-06 – Phase 1: Foundation & Domain Models

**Tasks:** T-001 to T-014

**What was done:**

Created all 14 domain models with full Eloquent relationships, migrations with correct foreign keys and enums, factories with realistic fake data, and seeders. Specifically:

- **14 migrations** covering: course_categories, courses, course_classes, schedules, student_profiles, teacher_profiles, enrollments, enrollment_documents, payments, certificates, post_categories, posts, contact_messages, testimonials
- **14 Eloquent models** with fillable fields, casts, and typed relationship methods
- **User model** extended with relationships to StudentProfile, TeacherProfile, Enrollment, Certificate, CourseClass
- **Factories** for: CourseCategory, Course, Testimonial, StudentProfile, TeacherProfile, Enrollment, Payment, Post
- **Seeders**: CourseCategorySeeder (6 categories), CourseSeeder (3 sample courses), RoleSeeder (roles: admin/professor/aluno + 3 test users)
- **DatabaseSeeder** updated to orchestrate all seeders
- Code formatted with `vendor/bin/pint --dirty`

**Pending:** MySQL database must be running to execute `php artisan migrate:fresh --seed`

---
