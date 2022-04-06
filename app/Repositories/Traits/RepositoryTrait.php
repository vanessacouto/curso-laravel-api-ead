<?php

namespace App\Repositories\Traits;

use App\Models\User;

trait RepositoryTrait
{
    // retorna o usuário autenticado
    private function getUserAuth(): User
    {
        return auth()->user();
    }
}
