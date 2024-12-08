<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Close extends Model
{
    use HasFactory;
    protected $table='closes';
    protected $fillable=[
        'start_time',
        'end_time',
        'description',
        'description',
        'team_id'
    ];
    public  function team():  BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
