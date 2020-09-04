<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RouterWarning extends Mailable
{
    use Queueable, SerializesModels;

    public $recipient;
    public $router;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($recipient, $router)
    {
        $this->recipient = $recipient;
        $this->router = $router;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.router_status_warning')
                    ->subject(__('mail.router_status_warning'));
    }
}
