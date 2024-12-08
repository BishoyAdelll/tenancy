<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'slug'
    ];

//    public function user(): HasMany
//
//    {
//        return $this->hasMany(User::class);
//    }
    public function additions(): HasMany

    {
        return $this->hasMany(Addition::class);
    }
    public function appointments(): HasMany

    {
        return $this->hasMany(Appointment::class);
    }
    public function reservations(): HasMany

    {
        return $this->hasMany(Reservation::class);
    }
    public function Tasks(): HasMany

    {
        return $this->hasMany(Task::class);
    }
    public function halls(): HasMany

    {
        return $this->hasMany(Hall::class);
    }
    public function closes(): HasMany
    {
            return $this->hasMany(Close::class);
    }

    public function members () : BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function user()
    {
        return $this->belongsToMany(User::class);
    }


}
