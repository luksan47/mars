<?php

namespace App\Mail;

use App\Models\Fault;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewFault extends Mailable
{
    use Queueable, SerializesModels;

    public string $recipient;
    public Fault $fault;
    public bool $reopen;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $recipient, Fault $fault, bool $reopen)
    {
        $this->recipient = $recipient;
        $this->fault = $fault;
        $this->reopen = $reopen;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.new_fault')->subject(__('faults.fault_subject'));
    }
}
