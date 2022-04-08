<?php

namespace App\Repositories;

use App\Models\Course;

class CourseRepository
{
    protected $entity;

    // no construtor, injeta o model que esse repository vai trabalhar
    // a partir dessa instancia do model, faremos nossas queries
    public function __construct(Course $model)
    {
        $this->entity = $model;
    }

    public function getAllCourses()
    {
        // com o 'with' é possivel recuperar os cursos, os modulos e as aulas com 3 consultas
        // sem o 'with', para cada módulo do curso uma nova consulta seria feita para pegar as aulas de cada Modulo (se tivessem 200 módulos, teríamos 200 consultas a mais)
        return $this->entity->with('modules.lessons')->get();
        
        //return $this->entity->get();
    }
    
    public function getCourse(string $identify)
    {
        // com o 'with' é possivel recuperar os cursos, os modulos e as aulas com 3 consultas
        return $this->entity->with('modules.lessons')->findOrFail($identify);
    }
}
