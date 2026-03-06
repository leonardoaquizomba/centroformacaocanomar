# CANOMAR – Implementation Log

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
