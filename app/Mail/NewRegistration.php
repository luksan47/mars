<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewRegistration extends Mailable
{
    use Queueable, SerializesModels;

    public string $recipient;
    public \App\Models\User $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $recipient, \App\Models\User $user)
    {
        $this->recipient = $recipient;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.new_registration')
            ->subject(__('mail.new-registration-subject'));
    }
}
