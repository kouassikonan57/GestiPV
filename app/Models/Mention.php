<?php

namespace App\Models;

use App\Models\Scopes\UserScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mention extends Model
{
    use HasFactory;

    protected $fillable = [
        'etudiant_id',
        'ue_id',
        'moyenne',
        'decision',
        'mention',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new UserScope());
    }

    public function etudiant(): BelongsTo
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function ue(): BelongsTo
    {
        return $this->belongsTo(Ue::class);
    }
}
