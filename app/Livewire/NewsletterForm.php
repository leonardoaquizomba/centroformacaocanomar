<?php

namespace App\Livewire;

use App\Models\NewsletterSubscriber;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;

class NewsletterForm extends Component
{
    public string $email = '';

    public string $name = '';

    public bool $compact = false;

    public bool $subscribed = false;

    public function subscribe(): void
    {
        $this->validate([
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('newsletter_subscribers', 'email')->whereNull('unsubscribed_at'),
            ],
            'name' => ['nullable', 'string', 'max:100'],
        ], [
            'email.unique' => 'Este e-mail já está subscrito à nossa newsletter.',
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
