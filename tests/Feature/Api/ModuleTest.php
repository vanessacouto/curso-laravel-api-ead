<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Course;
use App\Models\Module;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ModuleTest extends TestCase
{
    use UtilsTrait;

    public function test_get_modules_unauthenticated()
    {
        $response = $this->getJson('/courses/fake_value/modules');

        $response->assertStatus(401);
    }

    public function test_get_modules_course_not_found()
    {
        $response = $this->getJson('/courses/fake_value/modules', $this->defaultHeaders());

        // nesse caso não retornamos 404 devido a implementação feita, então verficamos se retornou zero itens
        $response->assertStatus(200)
            ->assertJsonCount(0, 'data');
    }

    public function test_get_modules_course()
    {
        $course = Course::factory()->create();

        $response = $this->getJson('/courses/{$course->id}/modules', $this->defaultHeaders());

        $response->assertStatus(200);
    }

    public function test_get_modules_course_total()
    {
        $course = Course::factory()->create();
        // cria 10 módulos para o curso criado acima
        Module::factory()->count(10)->create([
            'course_id' => $course->id // cria os modulos referentes ao curso que acabamos de criar
        ]);

        $response = $this->getJson("/courses/{$course->id}/modules", $this->defaultHeaders());

        $response->assertStatus(200)
            ->assertJsonCount(10, 'data');
    }
}
