<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as ModelsRole;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Role extends ModelsRole
{
    use HasFactory;


    public function team(): BelongsTo
{
    return $this->belongsTo(Team::class);
}
}
