<?php

namespace App\Livewire;

use App\Models\ContactMessage;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ContactForm extends Component
{
    #[Validate('required|min:2|max:100')]
    public string $name = '';

    #[Validate('required|email|max:100')]
    public string $email = '';

    #[Validate('nullable|max:20')]
    public string $phone = '';

    #[Validate('required|min:10|max:2000')]
    public string $message = '';

    public bool $sent = false;

    public function send(): void
    {
        $this->validate();

        ContactMessage::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone ?: null,
            'message' => $this->message,
        ]);

        $this->reset(['name', 'email', 'phone', 'message']);
        $this->sent = true;
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.contact-form');
    }
}
