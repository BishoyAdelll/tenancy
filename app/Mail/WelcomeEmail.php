<?php

namespace App\Mail;

use App\Models\Addition;
use App\Models\AppointmentAddition;
use App\Models\Hall;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $eamilMessage;
//    public $subject;


    public $record;
    public $testArray = [];
    public $hall;
    public $tests;
    /**
     * Create a new message instance.
     */
    public function __construct($message,$record)
    {
        $this->eamilMessage = $message;
        $testArray=null;
        $tests=AppointmentAddition::where('appointment_id',$record->id)->get();

        foreach ($tests as $test){
            $testArray[]=Addition::where('id',$test->addition_id)->first();
        }
        $hall= Hall::where('id',$record->hall_id)->first();
        $this->hall = $hall;
        $this->testArray=$testArray;
        $this->tests=$tests;
        $this->record=$record;

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.welcome-mail',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {

        return [

        ];
    }
}
