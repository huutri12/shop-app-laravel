<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;


class OrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $cart;
    public $total;
    public $orderData;
    /**
     * Create a new message instance.
     */
    public function __construct($user, $cart, $total, $orderData)
    {
        $this->user = $user;
        $this->cart      = $cart;
        $this->total     = $total;
        $this->orderData = $orderData;
    }

    public function build()
    {
        return $this->subject('Thông tin đơn hàng của bạn')
            ->markdown('emails.order');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.order',
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
