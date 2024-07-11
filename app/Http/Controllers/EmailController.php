<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeEmail;
use App\Models\Addition;
use App\Models\Appointment;
use App\Models\AppointmentAddition;
use App\Models\Hall;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{

    public function sendWelcomeEmail (Appointment $record)
    {
        try {
            $toEmail = $record->email;
            $message = 'welcome in Angel Michael Sheraton Church';
            Mail::to($toEmail)->send(new WelcomeEmail($message,$record));
            return redirect()->back();
        }catch (\Exception $e) {
            // Log the exception
            Log::error('Error sending email: ' . $e->getMessage());
            // Flash an informative error message
            return redirect()->back()->with('error', 'An error occurred while sending the email. Please try again later.');
        }
    }
}
