<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Finalise extends Mailable
{
    use Queueable, SerializesModels;

    protected $recipient;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $recipient )
    {
        $this->recipient = $recipient;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mails.finalise')
                    ->subject('Jelentkezés véglegesítése')
                    ->from('felveteli@eotvos.elte.hu','Eotvos Collegium')
                    ->replyTo('felveteli@eotvos.elte.hu','Eotvos Collegium')
                    ->bcc('felveteli@eotvos.elte.hu','Eotvos Collegium')
                    ->with('recipient',$this->recipient);
    }
}
