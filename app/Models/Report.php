<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'student_id',
        'creation_date',
        'semester',
        'overall_average',
        'final_decision',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
