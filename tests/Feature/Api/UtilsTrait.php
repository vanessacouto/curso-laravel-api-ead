<?php

namespace Tests\Feature\Api;

use App\Models\User;

trait UtilsTrait
{
    public function createUser()
    {
        $user = User::factory()->create();

        return $user;
    }

    public function createTokenUser()
    {
        // cria um usuário
        $user = $this->createUser();

        // cria um token para o usuário
        $token = $user->createToken('teste')->plainTextToken;

        return $token;
    }

    public function defaultHeaders()
    {
        $token = $this->createTokenUser();

        return [
            'Authorization' => "Bearer {$token}"
        ];
    }
}
