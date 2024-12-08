<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;
class SendSMScontroller extends Controller
{
    public function send()
    {
        $basic  = new \Vonage\Client\Credentials\Basic("88bea5a7", "mMQc9Yo9EpL62RF9");
        $client = new \Vonage\Client($basic);
        $message = $client->sms()->send(
            new \Vonage\SMS\Message\SMS("201226764759", 'bishoy adel', 'your order its confirmed at  Angel Michael Sheraton Church ')
        );
       return response()->json('message has been sent successfully ',200);



//        $sid    = getenv("TWILIO_SID");
//        $token  =getenv("TWILIO_TOKEN");
//        $senderNumber= getenv("TWILIO_PHONE");
//        $twilio = new Client($sid, $token);
//
//        $message = $twilio->messages
//            ->create("+20 12 26764759", [
//                "body" => 'test twilio sms',
//                "from" => $senderNumber
//            ]);
//        dd('send successfully');


    }
}
