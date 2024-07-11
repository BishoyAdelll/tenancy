<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Hall extends Model
{
    use HasFactory;
    protected $table='halls';
    protected $fillable=[
        'name',
        'slug',
        'location',
        'address',
        'type',
        'Maximum_number_of_people',
        'hall_price',
        'image',
        'team_id'
    ];

    protected $casts=[
        'image'=>'array'
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
    public  function team():  BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
