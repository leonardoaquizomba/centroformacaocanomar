# CANOMAR – Task Backlog

## Legend

- `[x]` Completed
- `[ ]` Pending
- `[~]` In Progress

---

## PHASE 1 – Foundation & Domain Models

- [x] T-001 – CourseCategory model + migration + factory + seeder
- [x] T-002 – Course model + migration + factory + seeder
- [x] T-003 – CourseClass model + migration + factory
- [x] T-004 – Schedule model + migration
- [x] T-005 – StudentProfile model + migration + factory
- [x] T-006 – TeacherProfile model + migration + factory
- [x] T-007 – Enrollment model + migration + factory
- [x] T-008 – EnrollmentDocument model + migration
- [x] T-009 – Payment model + migration + factory
- [x] T-010 – Certificate model + migration
- [x] T-011 – Post + PostCategory models + migrations + factories
- [x] T-012 – ContactMessage model + migration
- [x] T-013 – Testimonial model + migration + factory
- [x] T-014 – RoleSeeder (admin, professor, aluno) + test users

---

## PHASE 2 – Filament Admin Panel

- [x] T-015 – CourseCategoryResource
- [x] T-016 – CourseResource
- [x] T-017 – CourseClassResource
- [x] T-018 – StudentResource
- [x] T-019 – TeacherResource
- [x] T-020 – EnrollmentResource (with approve/reject actions)
- [x] T-021 – PaymentResource (with mark-as-paid action)
- [x] T-022 – CertificateResource (with generate action)
- [x] T-023 – PostResource (blog CRUD)
- [x] T-024 – ContactMessageResource (inbox)
- [x] T-025 – TestimonialResource
- [x] T-026 – Admin Dashboard Widgets (TotalStudents, ActiveCourses, MonthlyEnrollments, MonthlyRevenue)

---

## PHASE 3 – Student & Teacher Portals (Filament Panels)

- [x] T-027 – StudentPanelProvider (path: /aluno)
- [x] T-028 – Student Dashboard widgets
- [x] T-029 – MyEnrollmentsResource (student view)
- [x] T-030 – MyCertificatesResource (student download)
- [x] T-031 – MaterialsResource (student download)
- [x] T-032 – GradesResource (student view)
- [x] T-033 – MyCalendarPage (Livewire, student schedules)
- [x] T-034 – Student profile page (extended)
- [x] T-035 – TeacherPanelProvider (path: /professor)
- [x] T-036 – Teacher Dashboard widgets
- [x] T-037 – MyClassesResource (teacher view)
- [x] T-038 – AttendanceResource
- [x] T-039 – GradeEntryResource
- [x] T-040 – MaterialUploadResource
- [x] T-041 – ClassReportPage

---

## PHASE 4 – Public Website

- [x] T-042 – Responsive layout (navbar, footer, social links)
- [x] T-043 – Home page (hero, featured courses, stats, testimonials, blog posts)
- [x] T-044 – Courses catalog with Livewire search + filters
- [x] T-045 – Course detail page
- [x] T-046 – Online enrollment multi-step Livewire form
- [x] T-047 – About Us page
- [x] T-048 – Contacts page (contact form via Livewire; map placeholder)
- [x] T-049 – Blog/News list and post detail
- [x] T-050 – Certificate verification page

---

## PHASE 5 – Business Logic & Automation

- [x] T-051 – SendEnrollmentReceivedEmail mailable
- [x] T-052 – SendEnrollmentApprovedEmail mailable
- [x] T-053 – SendEnrollmentConfirmedEmail mailable
- [x] T-054 – GenerateCertificateJob (dompdf, queued)
- [x] T-055 – Secure document/certificate download routes
- [x] T-056 – ProcessPaymentApproval action

---

## PHASE 6 – Security & Configuration

- [ ] T-057 – Filament Shield policies for all resources (deferred)
- [x] T-058 – Form Request validation classes
- [x] T-059 – Private storage disk configuration
- [x] T-060 – Google Analytics integration
- [x] T-061 – Queue + schedule configuration

---

## PHASE 7 – Tests

- [x] T-062 – Feature: enrollment flow
- [x] T-063 – Feature: certificate generation job
- [x] T-064 – Feature: public pages
- [x] T-065 – Feature: admin Filament resources
- [x] T-066 – Unit: models and business logic

---

## PHASE 8 – Advanced Features (Post-MVP)

- [x] T-067 – Newsletter subscription (homepage section + footer widget, Livewire form, admin resource, unsubscribe route)
- [ ] T-068 – Multilingual (pt/en) with URL prefixes
- [ ] T-069 – Internal messaging system
- [ ] T-070 – In-app notifications
- [ ] T-071 – 2FA for student portal

---

## Known Issues & Technical Debt

- **AdminResourcesTest 403 (pre-existing)**: `admin can list courses/enrollments/payments` tests fail with 403 in the test environment — Filament Shield permissions are not being seeded correctly for the test admin user. Requires investigating `RoleSeeder` in tests or `sync-permissions` in `TestCase::setUp`.
- **Newsletter signed URLs (future)**: When newsletter emails are implemented, generate unsubscribe links with `URL::signedRoute()` and add `->middleware('signed')` to `routes/web.php:newsletter.unsubscribe`.
- **M5 – Laravel Policies**: No Policy classes defined for `Enrollment`, `Grade`, `Certificate`. Consider `php artisan make:policy EnrollmentPolicy --model=Enrollment` and adding `authorize()` checks in controllers.
