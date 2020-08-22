<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TopUpPrintBalance extends Mailable
{
    use Queueable, SerializesModels;

    public $recipient;
    public $amount;
    public $new_balance;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($recipient, $amount)
    {
        $this->recipient = $recipient;
        $this->amount = $amount;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.top_up_print_balance')
                    ->subject(__('print.topped_up_balance'));
    }
}
