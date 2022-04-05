<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\StoreSupport;
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

    // o metodo recebe o 'StoreSupport', que é onde colocamos nossas 'rules'
    public function store(StoreSupport $request)
    {
        $support = $this->repository
            ->createNewSupport($request->validated()); // $request->validated(): pega o que foi validado

        return new SupportResource($support);
    }
}
