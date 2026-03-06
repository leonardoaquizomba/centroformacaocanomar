<?php

use App\Models\Certificate;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\User;

it('home page returns successful response', function (): void {
    $this->get(route('home'))->assertSuccessful();
});

it('courses index page returns successful response', function (): void {
    $this->get(route('courses.index'))->assertSuccessful();
});

it('course detail page returns successful response for active course', function (): void {
    $course = Course::factory()->create(['is_active' => true]);

    $this->get(route('courses.show', $course->slug))->assertSuccessful();
});

it('course detail page returns 404 for unknown slug', function (): void {
    $this->get(route('courses.show', 'curso-inexistente'))->assertNotFound();
});

it('about page returns successful response', function (): void {
    $this->get(route('about'))->assertSuccessful();
});

it('contact page returns successful response', function (): void {
    $this->get(route('contact'))->assertSuccessful();
});

it('blog index page returns successful response', function (): void {
    $this->get(route('blog.index'))->assertSuccessful();
});

it('blog post detail page returns successful response', function (): void {
    $category = PostCategory::factory()->create();
    $post = Post::factory()->create([
        'post_category_id' => $category->id,
        'is_published' => true,
    ]);

    $this->get(route('blog.show', $post->slug))->assertSuccessful();
});

it('blog post detail returns 404 for unknown slug', function (): void {
    $this->get(route('blog.show', 'post-inexistente'))->assertNotFound();
});

it('certificate verification page returns successful response', function (): void {
    $this->get(route('certificate.verify'))->assertSuccessful();
});

it('certificate verification returns not found for invalid code', function (): void {
    $response = $this->postJson(route('certificate.verify.check'), ['code' => 'INVALID-CODE']);

    $response->assertSuccessful()
        ->assertJson(['found' => false]);
});

it('certificate verification returns certificate data for valid code', function (): void {
    $user = User::factory()->create();
    $course = Course::factory()->create();
    $enrollment = Enrollment::factory()->create([
        'user_id' => $user->id,
        'course_id' => $course->id,
    ]);
    Certificate::create([
        'enrollment_id' => $enrollment->id,
        'user_id' => $user->id,
        'course_id' => $course->id,
        'code' => 'CAN-2026-000001',
        'issued_at' => now(),
    ]);

    $response = $this->postJson(route('certificate.verify.check'), ['code' => 'CAN-2026-000001']);

    $response->assertSuccessful()
        ->assertJson([
            'found' => true,
            'code' => 'CAN-2026-000001',
            'student' => $user->name,
            'course' => $course->name,
        ]);
});

it('certificate verification requires code field', function (): void {
    $this->postJson(route('certificate.verify.check'), [])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['code']);
});

it('all public pages return 200 in a smoke test', function (string $url): void {
    $this->get($url)->assertSuccessful();
})->with([
    'home' => '/',
    'courses' => '/cursos',
    'about' => '/sobre',
    'contact' => '/contactos',
    'blog' => '/noticias',
    'certificate' => '/verificar-certificado',
]);
