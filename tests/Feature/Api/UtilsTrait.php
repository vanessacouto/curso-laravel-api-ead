<?php

namespace Tests\Feature\Api;

use App\Models\User;

trait UtilsTrait
{
    public function createTokenUser()
    {
        // cria um usuário
        $user = User::factory()->create();
        // cria um token para o usuário
        $token = $user->createToken('teste')->plainTextToken;

        return $token;
    }
}