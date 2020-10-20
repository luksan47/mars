<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NoPaper extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $userName)
    {
        //
        $this->userName = $userName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.no_paper')
            ->subject('No paper in printer');
    }
}
