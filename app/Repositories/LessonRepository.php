<?php

namespace App\Repositories;

use App\Models\Lesson;

class LessonRepository
{
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
}
