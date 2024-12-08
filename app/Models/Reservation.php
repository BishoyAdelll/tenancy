<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable=[
        'hall_id',
        'appointment_id',
        'booked_at',
        'start_time',
        'end_time',
        'number',
        'team_id'
    ];


    public function hall()
    {
        return $this->belongsTo(Hall::class);
    }
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
    public function closes()
    {
        return $this->belongsTo(Close::class); // Assuming your closing date model is named Close
    }
    public  function team():  BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
