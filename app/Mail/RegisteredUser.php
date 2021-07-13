<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisteredUser extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $new_password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $new_password)
    {
        $this->user = $user;
        $this->new_password = $new_password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mails.registered_user')->with([
            'user' => $this->user,
            'new_password' => $this->new_password,
        ])->subject('EJC Felvételi honlap felhasználó')->replyTo('root@eotvos.elte.hu')
        ->from('felveteli@eotvos.elte.hu', 'Eotvos Collegium')
        ->replyTo('felveteli@eotvos.elte.hu', 'Eotvos Collegium');
    }
}
