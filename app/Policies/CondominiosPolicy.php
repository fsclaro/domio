<?php

namespace App\Policies;

use App\Models\User;
use App\Enums\TypeEnum;
use App\Models\Condominios;
use Illuminate\Auth\Access\Response;

class CondominiosPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->is_active && (
            $user->type === TypeEnum::GESTOR->value
        ) ;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Condominios $condominio): bool
    {
        return $user->is_active && (
            $user->type === TypeEnum::GESTOR->value
        ) ;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->is_active && (
            $user->type === TypeEnum::GESTOR->value
        ) ;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Condominios $condominio): bool
    {
        return $user->is_active && (
            $user->type === TypeEnum::GESTOR->value
        ) ;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Condominios $condominio): bool
    {
        return $user->is_active && (
            $user->type === TypeEnum::GESTOR->value
        ) ;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Condominios $condominio): bool
    {
        return $user->is_active && (
            $user->type === TypeEnum::GESTOR->value
        ) ;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Condominios $condominio): bool
    {
        return $user->is_active && (
            $user->type === TypeEnum::GESTOR->value
        ) ;
    }
}
