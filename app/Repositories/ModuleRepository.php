<?php

namespace App\Repositories;

use App\Models\Module;

class ModuleRepository
{
    protected $entity;

    // no construtor, injeta o model que esse repository vai trabalhar
    // a partir dessa instancia do model, faremos nossas queries
    public function __construct(Module $model)
    {
        $this->entity = $model;
    }

    public function getModulesByCourseId(string $courseId)
    {
        return $this->entity
                    ->with('lessons.views') // vai trazer as lessons e as views
                    ->where('course_id', $courseId)
                    ->get();
    }
    
}
