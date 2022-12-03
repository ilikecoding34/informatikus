<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;
    public $type;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details, $type)
    {
        $this->details = $details;
        $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->type == 'comment'){
            $this->subject('Új hozzászólás');
            return $this->view('emails.commentMail');
        }else{
            $this->subject('Új regisztráció');
            return $this->view('emails.demoMail');
        }
    }
}
