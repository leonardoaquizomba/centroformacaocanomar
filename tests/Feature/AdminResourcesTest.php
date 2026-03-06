<?php

use App\Models\Course;
use App\Models\User;

beforeEach(function (): void {
    $this->admin = User::factory()->create();
    $this->admin->assignRole('admin');
});

it('admin can access the admin panel', function (): void {
    $this->actingAs($this->admin)
        ->get('/admin')
        ->assertSuccessful();
});

it('non-admin user cannot access admin panel', function (): void {
    $user = User::factory()->create();
    $user->assignRole('aluno');

    $this->actingAs($user)
        ->get('/admin')
        ->assertForbidden();
});

it('unauthenticated user is redirected from admin panel', function (): void {
    $this->get('/admin')->assertRedirect();
});

it('admin can list courses', function (): void {
    Course::factory()->count(3)->create();

    $this->actingAs($this->admin)
        ->get('/admin/courses')
        ->assertSuccessful();
});

it('admin can list enrollments', function (): void {
    $this->actingAs($this->admin)
        ->get('/admin/enrollments')
        ->assertSuccessful();
});

it('admin can list payments', function (): void {
    $this->actingAs($this->admin)
        ->get('/admin/payments')
        ->assertSuccessful();
});

it('student can access aluno portal', function (): void {
    $student = User::factory()->create();
    $student->assignRole('aluno');

    $this->actingAs($student)
        ->get('/aluno')
        ->assertSuccessful();
});

it('admin cannot access aluno portal', function (): void {
    $this->actingAs($this->admin)
        ->get('/aluno')
        ->assertForbidden();
});

it('teacher can access professor portal', function (): void {
    $teacher = User::factory()->create();
    $teacher->assignRole('professor');

    $this->actingAs($teacher)
        ->get('/professor')
        ->assertSuccessful();
});

it('admin cannot access professor portal', function (): void {
    $this->actingAs($this->admin)
        ->get('/professor')
        ->assertForbidden();
});
