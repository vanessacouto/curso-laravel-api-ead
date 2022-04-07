<?php

namespace Tests\Feature\Api\Auth;

use Tests\TestCase;
use App\Models\User;
use Tests\Feature\Api\UtilsTrait;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use UtilsTrait;

    public function test_fail_auth()
    {
        $response = $this->postJson('/auth', []); // chama '/auth' e não passa nada, para forçar o erro

        $response->assertStatus(422);
    }

    public function test_auth()
    {
        // cria um usuário para se autenticar
        $user = User::factory()->create();

        $response = $this->postJson('/auth', [
            'email' => $user->email,
            'password' => 'password',
            'device_name' => 'teste'
        ]); // vamos enviar os dados que essa requisicao exige

        // podemos visualizar qual foi a resposta da nossa request
        $response->dump();

        $response->assertStatus(200);
    }

    public function test_error_logout()
    {
        $response = $this->postJson('/logout', []);

        $response->assertStatus(401);
    }

    public function test_logout()
    {
        $token = $this->createTokenUser();

        // passar no Header Authorization da Request o nosso token
        $response = $this->postJson('/logout', [], [
            'Authorization' => "Bearer {$token}"
        ]);

        $response->assertStatus(200);
    }

    public function test_error_get_me()
    {
        // vai dar erro, pois necessita de 'Authorization' 
        $response = $this->getJSON('/me');

        $response->assertStatus(401);
    }

    public function test_get_me()
    {
        $token = $this->createTokenUser();

        // como é um 'get', o segundo parametro do método já é o 'header' da requisição
        $response = $this->getJSON('/me', [
            'Authorization' => "Bearer {$token}"
        ]);

        $response->assertStatus(200);
    }
}
