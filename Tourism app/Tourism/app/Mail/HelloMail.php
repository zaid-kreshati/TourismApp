<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class helloMail extends Mailable
{
    use Queueable, SerializesModels;

    private $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: $this->data['subject'],
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {

        // محتوى الايميل بينعرض عند الفيو , برسله معه
        // return  (new Content($this->data['body']))
        // ->view('index');

        // return (new Content($this->data['body']))
        //     ->with('body', $this->data['body'])
        //     ->view('index');

        return (new Content($this->data['body']))
            ->with('data', $this->data)
            ->view('mail');

        // return new Content(
        //     view: 'index',
        // );

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


    public function build()
    {

        return $this->from('travelovaa@gmail.com', 'Travelova')
            ->subject($this->data['subject']);

            // ->to('taknoor45@gmail.com');

    }
}