<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Repositories\CourseRepository;

class CourseController extends Controller
{
    protected $repository;

    // no construtor, injeta o model que esse repository vai trabalhar
    // a partir dessa instancia do model, faremos nossas queries
    public function __construct(CourseRepository $courseRepository)
    {
        $this->repository = $courseRepository;
    }

    // lista os cursos
    public function index()
    {
        return CourseResource::collection($this->repository->getAllCourses());
    }

    // retorna o curso do id especificado
    public function show($id)
    {
        return new CourseResource($this->repository->getCourse($id));
    }
}
