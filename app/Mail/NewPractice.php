<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewPractice extends Mailable
{
    use Queueable, SerializesModels;
    protected $practice;
    protected $url;
    protected $name;
    protected $unsubscribe;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($practice, $url, $name,  $unsubscribe)
    {
        $this->practice = $practice;
        $this->url = $url;
        $this->name = $name;
        $this->unsubscribe = $unsubscribe;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            from: new Address('info@asukamethod.com', 'Monpu san'),
            subject: 'New Practice uploaded!',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            markdown: 'emails.new-practice',
            with: [
                'title' => $this->practice->title,
                'url' => $this->url,
                'name' => $this->name,
                'unsubscribe'=>  $this->unsubscribe
            ]    
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
