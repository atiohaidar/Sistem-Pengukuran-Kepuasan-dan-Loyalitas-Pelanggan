<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class NewUserRegistered extends Mailable
{
    use Queueable, SerializesModels;

    public $newUser;

    public function __construct(User $newUser)
    {
        $this->newUser = $newUser;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'User Baru Mendaftar - Perlu Approval',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.new-user-registered',
            with: [
                'user' => $this->newUser,
            ],
        );
    }
}
