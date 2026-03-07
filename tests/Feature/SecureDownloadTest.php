<?php

use App\Models\Certificate;
use App\Models\Enrollment;
use App\Models\EnrollmentDocument;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

beforeEach(function (): void {
    Storage::fake('private');
});

// --- Certificate downloads ---

it('allows a student to download their own certificate', function (): void {
    $user = User::factory()->create();
    $enrollment = Enrollment::factory()->create(['user_id' => $user->id]);
    $certificate = Certificate::factory()->create([
        'user_id' => $user->id,
        'enrollment_id' => $enrollment->id,
        'file_path' => 'certificates/test.pdf',
    ]);
    Storage::disk('private')->put('certificates/test.pdf', 'pdf-content');

    $this->actingAs($user)
        ->get(route('download.certificate', $certificate))
        ->assertOk();
});

it('forbids a student from downloading another student\'s certificate', function (): void {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $enrollment = Enrollment::factory()->create(['user_id' => $owner->id]);
    $certificate = Certificate::factory()->create([
        'user_id' => $owner->id,
        'enrollment_id' => $enrollment->id,
        'file_path' => 'certificates/test.pdf',
    ]);
    Storage::disk('private')->put('certificates/test.pdf', 'pdf-content');

    $this->actingAs($other)
        ->get(route('download.certificate', $certificate))
        ->assertForbidden();
});

it('allows an admin to download any certificate', function (): void {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $owner = User::factory()->create();
    $enrollment = Enrollment::factory()->create(['user_id' => $owner->id]);
    $certificate = Certificate::factory()->create([
        'user_id' => $owner->id,
        'enrollment_id' => $enrollment->id,
        'file_path' => 'certificates/test.pdf',
    ]);
    Storage::disk('private')->put('certificates/test.pdf', 'pdf-content');

    $this->actingAs($admin)
        ->get(route('download.certificate', $certificate))
        ->assertOk();
});

it('returns 404 when certificate file does not exist on disk', function (): void {
    $user = User::factory()->create();
    $enrollment = Enrollment::factory()->create(['user_id' => $user->id]);
    $certificate = Certificate::factory()->create([
        'user_id' => $user->id,
        'enrollment_id' => $enrollment->id,
        'file_path' => 'certificates/missing.pdf',
    ]);

    $this->actingAs($user)
        ->get(route('download.certificate', $certificate))
        ->assertNotFound();
});

// --- Enrollment document downloads ---

it('allows a student to download their own enrollment document', function (): void {
    $user = User::factory()->create();
    $enrollment = Enrollment::factory()->create(['user_id' => $user->id]);
    $document = EnrollmentDocument::factory()->create([
        'enrollment_id' => $enrollment->id,
        'file_path' => 'documents/doc.pdf',
        'original_name' => 'doc.pdf',
    ]);
    Storage::disk('private')->put('documents/doc.pdf', 'pdf-content');

    $this->actingAs($user)
        ->get(route('download.document', $document))
        ->assertOk();
});

it('forbids a student from downloading another student\'s enrollment document', function (): void {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $enrollment = Enrollment::factory()->create(['user_id' => $owner->id]);
    $document = EnrollmentDocument::factory()->create([
        'enrollment_id' => $enrollment->id,
        'file_path' => 'documents/doc.pdf',
        'original_name' => 'doc.pdf',
    ]);
    Storage::disk('private')->put('documents/doc.pdf', 'pdf-content');

    $this->actingAs($other)
        ->get(route('download.document', $document))
        ->assertForbidden();
});

it('allows an admin to download any enrollment document', function (): void {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $owner = User::factory()->create();
    $enrollment = Enrollment::factory()->create(['user_id' => $owner->id]);
    $document = EnrollmentDocument::factory()->create([
        'enrollment_id' => $enrollment->id,
        'file_path' => 'documents/doc.pdf',
        'original_name' => 'doc.pdf',
    ]);
    Storage::disk('private')->put('documents/doc.pdf', 'pdf-content');

    $this->actingAs($admin)
        ->get(route('download.document', $document))
        ->assertOk();
});
