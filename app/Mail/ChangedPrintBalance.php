<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ChangedPrintBalance extends Mailable
{
    use Queueable, SerializesModels;

    public $recipient; //User model
    public $amount; //how much the balance has changed
    public $modifier; //modifier's name

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($recipient, $amount, $modifier)
    {
        $this->recipient = $recipient;
        $this->amount = $amount;
        $this->modifier = $modifier;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.changed_print_balance')
                    ->subject(__('print.changed_balance'));
    }
}
