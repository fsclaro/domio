<?php

namespace App\Policies;

use App\Models\User;
use App\Enums\TypeEnum;
use App\Models\Comunicados;
use Illuminate\Auth\Access\Response;

class ComunicadosPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->is_active && (
            $user->type === TypeEnum::GESTOR->value ||
            $user->type === TypeEnum::PROPRIETARIO_MORADOR->value
        );
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Comunicados $comunicado): bool
    {
        return $user->is_active && (
            $user->type === TypeEnum::GESTOR->value ||
            $user->type === TypeEnum::PROPRIETARIO_MORADOR->value
        );
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->is_active && (
            $user->type === TypeEnum::GESTOR->value ||
            $user->type === TypeEnum::PROPRIETARIO_MORADOR->value
        );
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Comunicados $comunicado): bool
    {
        return $user->is_active && (
            $user->type === TypeEnum::GESTOR->value ||
            $user->type === TypeEnum::PROPRIETARIO_MORADOR->value
        );
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Comunicados $comunicado): bool
    {
        return $user->is_active && (
            $user->type === TypeEnum::GESTOR->value ||
            $user->type === TypeEnum::PROPRIETARIO_MORADOR->value
        );
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Comunicados $comunicado): bool
    {
        return $user->is_active && (
            $user->type === TypeEnum::GESTOR->value ||
            $user->type === TypeEnum::PROPRIETARIO_MORADOR->value
        );
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Comunicados $comunicado): bool
    {
        return $user->is_active && (
            $user->type === TypeEnum::GESTOR->value ||
            $user->type === TypeEnum::PROPRIETARIO_MORADOR->value
        );
    }
}
