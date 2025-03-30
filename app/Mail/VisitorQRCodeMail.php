<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VisitorQRCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $visitor;
    public $qrCode;

    /**
     * Create a new message instance.
     */
    public function __construct($visitor, $qrCode)
    {
        $this->visitor = $visitor;
        $this->qrCode = $qrCode;
    }
    public function build()
    {
        return $this->view('emails.visitor_qr_code')
            ->subject('Your Visitor QR Code')
            ->with([
                'visitor' => $this->visitor,
                'qrCode' => $this->qrCode,
            ]);
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Visitor Q R Code Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
