<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Semestre extends Model
{
    use HasFactory;
    protected $fillable = [
        'libelle',
        'session',
    ];

    /**
     * Relation avec les UE (Unités d'Enseignement).
     */
    public function ues(): HasMany
    {
        return $this->hasMany(Ue::class);
    }
}
