<?php

namespace App\Mail;

use App\Models\Peminjaman;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SuspensionWarning extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Peminjaman $peminjaman,
        public int $daysLate
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '⚠️ Peringatan: Peminjaman Anda Telat',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.suspension-warning',
            with: [
                'peminjaman' => $this->peminjaman,
                'daysLate' => $this->daysLate,
                'userName' => $this->peminjaman->user->name,
                'barangName' => $this->peminjaman->barang->nama_barang,
            ]
        );
    }
}
