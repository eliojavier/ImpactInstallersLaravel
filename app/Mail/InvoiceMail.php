<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice_number;
    public $email;

    /**
     * Create a new message instance.
     * @param $invoice_number
     * @param $email
     */
    public function __construct($invoice_number, $email)
    {
        $this->invoice_number = $invoice_number;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.invoice')
            ->from('impact.installers@gmail.com')
            ->to($this->email)
            ->subject('Invoice')
            ->attach('invoices/'.$this->invoice_number.'.pdf');
    }
}
