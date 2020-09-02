<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StateCertificateRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $recipient;
    public $user;
    public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($recipient, $user, $url)
    {
        $this->recipient = $recipient;
        $this->user = $user;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.status_certificate_request')
                    ->subject(__('mail.status_certificate_request_subject'));
    }
}
