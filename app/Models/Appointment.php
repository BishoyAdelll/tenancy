<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Appointment extends Model
{
    use HasFactory;
    protected $table='appointments';

    protected $fillable=[
        'number',
        'man_name',
        'man_phone',
        'women_name',
        'email',
        'address',
        'man_id',
        'women_phone',
        'women_id',
        'image',
        'start_time',
        'end_time',
        'hall_id',
        'hall_price',
        'the_numbers_of_hours',
        'discount',
        'tax',
        'grand_total',
        'discount_halls',
        'Payment',
        'status',
        'confirmedDate',
        'is_edited',
        'paid',
        'dates',
        'hall',
        'hall_rival',
        'total_price',
        'residual',
        'insurance',
        'photography',
        'team_id'
    ];
    protected $casts=[
        'image'=>'array',
        'dates' =>'json'
    ];


    public function hall(): BelongsTo
    {
        return $this->belongsTo(Hall::class);
    }
    public function additions():HasMany
    {
        return $this->hasMany(AppointmentAddition::class);
    }


    public function getpreviuos ()
    {
        $date=Carbon::parse($this->start_time);
        $supmonth = $date->subMonth();
        return $supmonth->format('F d ');
    }
    public function getNextMonth ()
    {
        $date=Carbon::parse($this->start_time);
        $supmonth = $date->subMonths(1);
        return $supmonth->format('F d ');
    }
    public function getNextTowMonth ()
    {
        $date=Carbon::parse($this->start_time);
        $supmonth = $date->subMonths(2);
        return $supmonth->format('F d ');
    }
    public function getNextThreeMonth ()
    {
        $date=Carbon::parse($this->start_time);
        $supmonth = $date->subMonths(3);
        return $supmonth->format('F d ');
    }
    public function getNextForeMonth ()
    {
        $date=Carbon::parse($this->start_time);
        $supmonth = $date->subMonths(4);
        return $supmonth->format('F d ');
    }
    public function getFormatedDate ()
    {
        $date=Carbon::parse($this->start_time);
        return $date->format('Y-m-d l');
    }
    public function getFormatedTime ()
    {
        $date=Carbon::parse($this->start_time);
        return $date->format('h:i A');
    }
    public function getFormatedENDTime ()
    {
        $date=Carbon::parse($this->end_time);
        return $date->format('h:i A');
    }
    public function Times ()
    {
        return $this->dates;
    }

    public  function team():  BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
