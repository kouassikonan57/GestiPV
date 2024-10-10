<?php

namespace App\Models;

use App\Models\Scopes\UserScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reclamation extends Model
{
    use HasFactory;
    protected $fillable = [
        'libelle',
        'description',
        'etudiant_id',
        'note_id',
    ];

    public function etudiant(): BelongsTo
    {
        return $this->belongsTo(Etudiant::class);
    }
    protected static function booted(): void
    {
        static::addGlobalScope(new UserScope());
    }
    public function note(): BelongsTo
    {
        return $this->belongsTo(Note::class);
    }
}
