<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LessonTest extends TestCase
{
    use UtilsTrait;

    public function test_get_lessons_unauthenticated()
    {
        $response = $this->getJson('/modules/fake_value/lessons');

        $response->assertStatus(401);
    }

    public function test_get_lessons_of_module_not_found()
    {
        $response = $this->getJson('/modules/fake_value/lessons', $this->defaultHeaders());

        // nesse caso não retornamos 404 devido a implementação feita, então verficamos se retornou zero itens
        $response->assertStatus(200)
            ->assertJsonCount(0, 'data');
    }

    public function test_get_lessons_module()
    {
        $course = Course::factory()->create();

        $response = $this->getJson('/modules/{$course->id}/lessons', $this->defaultHeaders());

        $response->assertStatus(200);
    }

    public function test_get_lessons_of_module_total()
    {
        $module = Module::factory()->create();
        // cria 10 aulas para o módulo criado acima
        Lesson::factory()->count(10)->create([
            'module_id' => $module->id // cria aulas referentes ao módulo que acabamos de criar
        ]);

        $response = $this->getJson("/modules/{$module->id}/lessons", $this->defaultHeaders());

        $response->assertStatus(200)
            ->assertJsonCount(10, 'data');
    }

    public function test_get_single_lesson_unauthenticated()
    {
        $response = $this->getJson('/lessons/fake_value');

        $response->assertStatus(401);
    }

    public function test_get_single_lesson_not_found()
    {
        $response = $this->getJson('/lessons/fake_value', $this->defaultHeaders());

        $response->assertStatus(404);
    }

    public function test_get_single_lesson()
    {
        $lesson = Lesson::factory()->create();

        $response = $this->getJson("/lessons/{$lesson->id}", $this->defaultHeaders());

        $response->assertStatus(200);
    }
}
