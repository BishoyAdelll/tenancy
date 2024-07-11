<?php

use Illuminate\Support\Facades\Route;
Route::get('/{record}/pdf/dwonload',[\App\Http\Controllers\DownloadBdfController::class,'generateInvoice'])->name('student.pdf.dwonload');
Route::get('/{record}/pdf/viewInvoice',[\App\Http\Controllers\DownloadBdfController::class,'viewInvoice'])->name('student.pdf.view');
Route::get('/{appointment}/pdf/viewInformation',[\App\Http\Controllers\InformationController::class,'viewInformation'])->name('student.pdf.viewInformation');
Route::get('/{appointment}/pdf/downloadInformation',[\App\Http\Controllers\InformationController::class,'generateInformation'])->name('student.pdf.generateInformation');
Route::get('/{appointment}/pdf/viewCrown',[\App\Http\Controllers\InformationController::class,'viewCrown'])->name('student.pdf.viewCrown');
Route::get('/{appointment}/pdf/downloadCrown',[\App\Http\Controllers\InformationController::class,'generateCrown'])->name('student.pdf.generateCrown');
Route::get('send-sms',[\App\Http\Controllers\SendSMScontroller::class,'send']);
Route::get('/{record}/send-email',[\App\Http\Controllers\EmailController::class,'sendWelcomeEmail'])->name('send.gmail');
Route::get('/', function () {
    return view('welcome');
});
