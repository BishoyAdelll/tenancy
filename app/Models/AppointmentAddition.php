<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AppointmentAddition extends Model
{
    use HasFactory;
    protected $table='appointment_additions';
    protected $fillable=
        [
            'appointment_id',
            'addition_id',
            'price',
            'quantity',
            'total_addtions',

        ];


    public function additions(): BelongsToMany
    {
        return $this->belongsToMany(Addition::class);
    }
    public function addition()
    {
        return $this->belongsTo(Addition::class);
    }
}
