<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'valeur',
        'date',
        'etudiant_id',
        'ecue_id',
    ];

    public function ecue(): BelongsTo
    {
        return $this->belongsTo(Ecue::class);
    }

    public function etudiant(): BelongsTo
    {
        return $this->belongsTo(Etudiant::class);
    }

    protected static function booted()
    {
        // Calculer la moyenne de l'UE chaque fois qu'une note est créée ou mise à jour
        static::saved(function ($note) {
            $ue = $note->ecue->ue;
            $etudiant_id = $note->etudiant->id;
            $ue->calculerMoyennePourEtudiant($etudiant_id);
        });
    }
}
