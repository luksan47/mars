<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EpistolaCollegii extends Mailable
{
    use Queueable, SerializesModels;

    public $epistolas;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($epistolas)
    {
        $this->epistolas = $epistolas;
        $this->theme = 'epistola';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Epistola Collegii - '.now()->format('Y. m. d.'))
            ->markdown('emails.epistola', ['news' => $this->epistolas]);
    }
}
