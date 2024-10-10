<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class UserScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->hasRole('Etudiant')) {
                $fillable = $model->getFillable();
                if (in_array('user_id', $fillable)) {
                    $builder->where('user_id', $user->id);
                } elseif (in_array('etudiant_id', $fillable)) {
                    $builder->where('etudiant_id', $user->id);
                }
            }
        }
    }
}
