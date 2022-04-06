<?php

namespace App\Repositories;

use App\Models\Lesson;
use App\Repositories\Traits\RepositoryTrait;

class LessonRepository
{
    use RepositoryTrait;

    protected $entity;

    // no construtor, injeta o model que esse repository vai trabalhar
    // a partir dessa instancia do model, faremos nossas queries
    public function __construct(Lesson $model)
    {
        $this->entity = $model;
    }

    public function getLessonsByModuleId(string $moduleId)
    {
        return $this->entity
            ->where('module_id', $moduleId)
            ->get();
    }

    public function getLesson(string $identify)
    {
        return $this->entity->findOrFail($identify);
    }

    public function markLessonViewed(string $lessonId)
    {
        $user = $this->getUserAuth();
        $view = $user->views()->where('lesson_id', $lessonId)->first(); // verifica se esse usuario já tem algum View para essa Lesson

        if ($view) { // se já tem algum View
            // faz update, incrementando 'mais um' na 'quantidade'
            return $view->update([
                'qty' => $view->qty + 1,
            ]);
        }

        // insere nova View para a Lesson
        return $user->views()->create([
            'lesson_id' => $lessonId
        ]);
    }
}
