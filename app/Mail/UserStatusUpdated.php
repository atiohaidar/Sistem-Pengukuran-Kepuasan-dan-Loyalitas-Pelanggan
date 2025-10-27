<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class UserStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $newStatus;

    public function __construct(User $user, string $newStatus)
    {
        $this->user = $user;
        $this->newStatus = $newStatus;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Status Akun Anda Telah Diperbarui',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.user-status-updated',
            with: [
                'user' => $this->user,
                'status' => $this->newStatus,
            ],
        );
    }
}
