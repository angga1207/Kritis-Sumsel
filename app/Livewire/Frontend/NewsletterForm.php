<?php

namespace App\Livewire\Frontend;

use App\Mail\NewsletterVerificationMail;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Component;

class NewsletterForm extends Component
{
    public string $email = '';

    public function subscribe(): void
    {
        $this->validate(['email' => 'required|email|max:255']);

        $subscriber = NewsletterSubscriber::firstOrNew(['email' => $this->email]);

        if (! $subscriber->exists) {
            $subscriber->verification_token = Str::random(40);
            $subscriber->is_verified = false;
            $subscriber->save();
        }

        if (! $subscriber->is_verified) {
            Mail::to($subscriber->email)->send(new NewsletterVerificationMail($subscriber));
        }

        $this->reset('email');
        $this->dispatch('toast', type: 'success', message: 'Silakan cek email Anda untuk konfirmasi langganan.');
    }

    public function render()
    {
        return view('livewire.frontend.newsletter-form');
    }
}
