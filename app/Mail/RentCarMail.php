<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RentCarMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $rent;

    /**
     * Create a new message instance.
     *
     * @param $user
     * @param $rent
     */
    public function __construct($user, $rent)
    {
        $this->user = $user;
        $this->rent = $rent;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.rent-car-mail');
    }
}
