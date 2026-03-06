# CANOMAR – Implementation Log

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
