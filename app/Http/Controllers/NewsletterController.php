<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\RedirectResponse;

class NewsletterController extends Controller
{
    public function unsubscribe(string $token): RedirectResponse
    {
        $subscriber = NewsletterSubscriber::where('token', $token)
            ->whereNull('unsubscribed_at')
            ->first();

        if ($subscriber) {
            $subscriber->update(['unsubscribed_at' => now()]);
            session()->flash('success', 'A sua subscrição foi cancelada com sucesso.');
        } else {
            session()->flash('info', 'Este link de cancelamento já foi utilizado ou é inválido.');
        }

        return redirect()->route('home');
    }
}
