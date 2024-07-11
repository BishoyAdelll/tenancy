<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use PDF;

class InformationController extends Controller
{
    public function viewInformation(Appointment $appointment)
    {
        return view('admin.invoice.information',compact('appointment'));
    }
    public  function generateInformation(Appointment $appointment)
    {
        $pdf=PDF::loadView('admin.invoice.information',compact('appointment'));
        $todayDate=Carbon::now()->format('d-m-y');
        return $pdf->download('invoice-'.$appointment->id.'-'.$todayDate.'.pdf');
    }
    public function viewCrown(Appointment $appointment)
    {
        return view('admin.invoice.Crown',compact('appointment'));
    }
    public  function generateCrown(Appointment $appointment)
    {
        $pdf=PDF::loadView('admin.invoice.Crown',compact('appointment'));
        $todayDate=Carbon::now()->format('d-m-y');
        return $pdf->download('invoice-'.$appointment->id.'-'.$todayDate.'.pdf');
    }
}
