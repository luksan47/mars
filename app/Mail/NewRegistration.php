<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewRegistration extends Mailable
{
    use Queueable, SerializesModels;

    public string $recipient;
    public string $registered_user;
    public  bool $is_collegist;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $recipient, string $registered_user,  bool $is_collegist)
    {
        $this->recipient=$recipient;
        $this->registered_user=$registered_user;
        $this->is_collegist=$is_collegist;
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
