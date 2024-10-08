<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ecue extends Model
{
    use HasFactory;

    protected $table = 'ecues';

    protected $fillable = [
        'libelle',
        'coefficient',
        'ue_id',
    ];

    public function ue(): BelongsTo
    {
        return $this->belongsTo(Ue::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }
}
