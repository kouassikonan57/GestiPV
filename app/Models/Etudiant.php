<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Etudiant extends User
{
    use HasFactory;
    protected $fillable = [
        'matricule',
        'nom',
        'prenom',
        'date_naissance',
        'lieu_naissance',
        'niveau',
        'parcours',
        'parcours_id',
    ];

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    public function parcours(): BelongsTo
    {
        return $this->belongsTo(Parcours::class);
    }

    public function procesVerbals(): HasMany
    {
        return $this->hasMany(ProcesVerbal::class);
    }


    /**
     * Relation avec les UE (Unités d'Enseignement).
     */
    public function ues(): HasMany
    {
        return $this->hasMany(Ue::class);
    }

}
