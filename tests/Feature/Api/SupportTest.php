<?php

namespace Tests\Feature\Api;

use App\Models\Support;
use Tests\TestCase;
use Tests\Feature\Api\UtilsTrait;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SupportTest extends TestCase
{
    use UtilsTrait;

    public function test_get_my_supports_unauthenticated()
    {
        $response = $this->getJson('/my-supports');

        $response->assertStatus(401);
    }

    public function test_get_my_supports()
    {
        $user = $this->createUser();
        // cria um token para o usuário
        $token = $user->createToken('teste')->plainTextToken;

        // cria 50 'supports' para o 'usuário autenticado'
        Support::factory()->count(50)->create([
            'user_id' => $user->id
        ]);

        // cria mais 50 'supports' de forma aleatório (sem ser pro usuário autenticado)
        Support::factory()->count(50)->create();

        $response = $this->getJson('/my-supports', [
            'Authorization' => "Bearer {$token}"
        ]);

        $response->assertStatus(200)
                    ->assertJsonCount(50, 'data'); // criamos 100 'supports', mas só 50 são do usuário autenticado
    }
}
