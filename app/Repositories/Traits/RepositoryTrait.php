<?php

namespace App\Repositories\Traits;

use App\Models\User;

trait RepositoryTrait
{
    // pegar usuário autenticado
    private function getUserAuth(): User
    {
        // quando tiver usuario autenticado
        //return auth()->user();

        return User::first();
    }
}
