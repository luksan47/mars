<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PayedTransaction extends Mailable
{
    use Queueable, SerializesModels;

    public $recipent;
    public array $transactions;
    public $additional_message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($recipent, array $transactions, $additional_message = null)
    {
        $this->recipent = $recipent;
        $this->transactions = $transactions;
        $this->additional_message = $additional_message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.payed_transaction')
                    ->subject(__('checkout.pay'));
    }
}
