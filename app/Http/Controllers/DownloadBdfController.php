<?php

namespace App\Http\Controllers;

use App\Models\Addition;
use App\Models\Appointment;
use App\Models\AppointmentAddition;
use App\Models\Hall;
use App\Models\Time;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use PDF;

class DownloadBdfController extends Controller
{
    public function viewInvoice(Appointment $record)
    {
        $testArray=null;
        $tests=AppointmentAddition::where('appointment_id',$record->id)->get();

        foreach ($tests as $test){
            $testArray[]=Addition::where('id',$test->addition_id)->first();
        }
        $hall= Hall::where('id',$record->hall_id)->first();
        return view('admin.invoice.generate-invoice',compact('record','testArray','hall','tests'));
    }
    public  function generateInvoice(Appointment $record)
    {
        $testArray=null;
        $tests=AppointmentAddition::where('appointment_id',$record->id)->get();
        foreach ($tests as $test){
            $testArray[]=Addition::where('id',$test->addition_id)->first();
        }
        $hall= Hall::where('id',$record->hall_id)->first();
        $pdf=PDF::loadView('admin.invoice.generate-invoice',compact('record','testArray','hall','tests'));
        $todayDate=Carbon::now()->format('d-m-y');
        return $pdf->download('invoice-'.$record->id.'-'.$todayDate.'.pdf');

    }
}
