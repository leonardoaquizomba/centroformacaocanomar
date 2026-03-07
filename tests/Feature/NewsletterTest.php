<?php

use App\Livewire\NewsletterForm;
use App\Mail\SendNewsletterWelcomeEmail;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Livewire\Livewire;

it('can subscribe with a valid email', function (): void {
    Mail::fake();

    Livewire::test(NewsletterForm::class)
        ->set('email', 'subscriber@example.com')
        ->set('name', 'João Silva')
        ->call('subscribe')
        ->assertSet('subscribed', true);

    expect(NewsletterSubscriber::where('email', 'subscriber@example.com')->exists())->toBeTrue();
    Mail::assertQueued(SendNewsletterWelcomeEmail::class);
});

it('stores the token and subscribed_at when subscribing', function (): void {
    Livewire::test(NewsletterForm::class)
        ->set('email', 'token@example.com')
        ->call('subscribe');

    $subscriber = NewsletterSubscriber::where('email', 'token@example.com')->first();

    expect($subscriber)->not->toBeNull()
        ->and($subscriber->token)->not->toBeEmpty()
        ->and($subscriber->subscribed_at)->not->toBeNull()
        ->and($subscriber->unsubscribed_at)->toBeNull();
});

it('silently succeeds on duplicate active email to prevent enumeration', function (): void {
    // Security: we must not reveal whether an email already exists in the database.
    // Duplicate submissions should succeed silently (OWASP A01 — Broken Access Control / information disclosure).
    NewsletterSubscriber::factory()->create(['email' => 'duplicate@example.com']);

    Livewire::test(NewsletterForm::class)
        ->set('email', 'duplicate@example.com')
        ->call('subscribe')
        ->assertHasNoErrors()
        ->assertSet('subscribed', true);
});

it('allows resubscription after unsubscribing', function (): void {
    NewsletterSubscriber::factory()->unsubscribed()->create(['email' => 'resubscribe@example.com']);

    Livewire::test(NewsletterForm::class)
        ->set('email', 'resubscribe@example.com')
        ->call('subscribe')
        ->assertSet('subscribed', true);
});

it('requires a valid email address', function (): void {
    Livewire::test(NewsletterForm::class)
        ->set('email', 'not-an-email')
        ->call('subscribe')
        ->assertHasErrors(['email']);
});

it('can unsubscribe via signed URL', function (): void {
    $subscriber = NewsletterSubscriber::factory()->create();

    $signedUrl = URL::signedRoute('newsletter.unsubscribe', ['token' => $subscriber->token]);

    $this->get($signedUrl)->assertRedirect(route('home'));

    expect($subscriber->fresh()->unsubscribed_at)->not->toBeNull();
});

it('rejects unsubscribe with tampered unsigned URL', function (): void {
    $subscriber = NewsletterSubscriber::factory()->create();

    // Plain route() without signature must be rejected by the signed middleware
    $this->get(route('newsletter.unsubscribe', $subscriber->token))
        ->assertRedirect(route('home'));

    // Subscriber should NOT be unsubscribed since the signature was missing
    expect($subscriber->fresh()->unsubscribed_at)->toBeNull();
});

it('handles invalid unsubscribe token gracefully', function (): void {
    $signedUrl = URL::signedRoute('newsletter.unsubscribe', ['token' => 'invalid-token']);

    $this->get($signedUrl)->assertRedirect(route('home'));
});

it('compact mode sets the compact property', function (): void {
    Livewire::test(NewsletterForm::class, ['compact' => true])
        ->assertSet('compact', true);
});
