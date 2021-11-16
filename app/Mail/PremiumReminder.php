<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PremiumReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $policy;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($policy)
    {
        $this->policy = $policy;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.premium-reminder');
    }
}
