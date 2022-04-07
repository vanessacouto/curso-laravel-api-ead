<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Lesson;
use App\Models\Support;
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

    public function test_get_supports_unauthenticated()
    {
        $response = $this->getJson('/supports');

        $response->assertStatus(401);
    }

    public function test_get_supports()
    {
        Support::factory()->count(50)->create();

        $response = $this->getJson('/supports', $this->defaultHeaders());

        $response->assertStatus(200)
            ->assertJsonCount(50, 'data');
    }

    public function test_get_supports_filter_lesson()
    {
        $lesson = Lesson::factory()->create();

        Support::factory()->count(50)->create();

        // cria 10 supports especificando a aula
        Support::factory()->count(10)->create([
            'lesson_id' => $lesson->id
        ]);

        $payload = ['lesson' => $lesson->id];

        // método 'json': passamos o verbo HTTP, a url, os dados e a Header
        $response = $this->json('GET', '/supports', $payload, $this->defaultHeaders());

        $response->assertStatus(200)
            ->assertJsonCount(10, 'data'); // criamos 60 'supports', mas estamos filtrando 10 'supports' especificos
    }

    public function test_create_support_unauthenticated()
    {
        $response = $this->postJson('/supports');

        $response->assertStatus(401);
    }

    public function test_create_support_error_validations()
    {
        $response = $this->postJson('/supports', [], $this->defaultHeaders());

        $response->assertStatus(422);
    }

    public function test_create_support()
    {
        $lesson = Lesson::factory()->create();

        $payload = [
            'lesson' => $lesson->id,
            'status' => 'P',
            'description' => 'Description Test',
        ];

        $response = $this->postJson('/supports', $payload, $this->defaultHeaders());

        $response->assertStatus(201);
    }
}
