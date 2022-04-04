<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SupportResource;
use App\Repositories\SupportRepository;

class SupportController extends Controller
{
    protected $repository;

    // no construtor, injeta o model que esse repository vai trabalhar
    // a partir dessa instancia do model, faremos nossas queries
    public function __construct(SupportRepository $supportRepository)
    {
        $this->repository = $supportRepository;
    }

    // lista todas as duvidas
    public function index(Request $request)
    {
        // '$request->all()': tudo que vier de parametro pela url é enviado
        $supports = $this->repository->getSupports($request->all());
        
        return SupportResource::collection($supports);
    }
}
