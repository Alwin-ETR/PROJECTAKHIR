<?php

namespace App\Mail;

use App\Models\Suspension;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserSuspended extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Suspension $suspension
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🚫 Akun Anda Terkena Suspend',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.user-suspended',
            with: [
                'suspension' => $this->suspension,
                'userName' => $this->suspension->user->name,
                'reason' => $this->suspension->reason,
                'suspendedUntil' => $this->suspension->suspended_until,
                'daysRemaining' => $this->suspension->getRemainingDays(),
            ]
        );
    }
}
