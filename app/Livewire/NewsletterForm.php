<?php

namespace App\Livewire;

use App\Models\NewsletterSubscriber;
use Illuminate\Support\Str;
use Livewire\Component;

class NewsletterForm extends Component
{
    public string $email = '';

    public string $name = '';

    public bool $compact = false;

    public bool $subscribed = false;

    public function subscribe(): void
    {
        // Do not reveal whether an email already exists — prevents email enumeration (OWASP A01).
        $this->validate([
            'email' => ['required', 'email', 'max:255'],
            'name' => ['nullable', 'string', 'max:100'],
        ]);

        NewsletterSubscriber::updateOrCreate(
            ['email' => $this->email],
            [
                'name' => $this->name ?: null,
                'token' => Str::uuid()->toString(),
                'subscribed_at' => now(),
                'unsubscribed_at' => null,
            ]
        );

        $this->subscribed = true;
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.newsletter-form');
    }
}
