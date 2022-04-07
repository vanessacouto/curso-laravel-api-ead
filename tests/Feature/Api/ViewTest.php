<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Lesson;
use Tests\Feature\Api\UtilsTrait;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewTest extends TestCase
{
    use UtilsTrait;

    public function test_make_viewed_unauthenticated()
    {
        $response = $this->postJson('/lessons/viewed');

        $response->assertStatus(401);
    }

    public function test_make_viewed_error_validator()
    {
        $payload = []; // não passa nenhuma 'lesson' para forçar o erro

        $response = $this->postJson(
            '/lessons/viewed',
            $payload,
            $this->defaultHeaders()
        );

        $response->assertStatus(422);
    }

    public function test_make_viewed_invalid_lesson()
    {
        $payload = [
            'lesson' => 'fake_lesson'
        ]; // passa uma 'lesson' que não existe para forçar o erro

        $response = $this->postJson(
            '/lessons/viewed',
            $payload,
            $this->defaultHeaders()
        );

        $response->assertStatus(422);
    }

    public function test_make_viewed()
    {
        $lesson = Lesson::factory()->create();
        $payload = [
            'lesson' => $lesson->id
        ];

        $response = $this->postJson(
            '/lessons/viewed',
            $payload,
            $this->defaultHeaders()
        );

        $response->assertStatus(200);
    }
}
