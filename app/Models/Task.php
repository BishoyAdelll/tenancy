<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;
    protected $fillable=[
        'time',
        'description',
        'user_id',
        'due_date',
        'appointment_id',
        'status',
        'hall',
        'number',
        'team_id'
    ];
    protected $casts = [
//        'due_date' => 'date',
//        'is_completed' => 'boolean',
    ];

    public  function user()
    {
        return $this->belongsTo(User::class);
    }

    public  function team():  BelongsTo
    {
        return $this->belongsTo(Team::class);
    }



    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
