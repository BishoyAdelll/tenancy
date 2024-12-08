<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Addition extends Model
{
    use HasFactory;
    protected $table='additions';
    protected $fillable=[
        'name',
        'description',
        'price',
        'team_id'
    ];

    public function addition()
    {
        return $this->belongsTo(AppointmentAddition::class);
    }
    public  function team():  BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
