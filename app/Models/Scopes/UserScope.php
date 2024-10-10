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
                if ($model->getAttribute('user_id') !== null) {
                    $builder->where('user_id', $user->id);
                } elseif ($model->getAttribute('etudiant_id') !== null) {
                    $builder->where('etudiant_id', $user->id);
                }
            }
        }
    }
}
