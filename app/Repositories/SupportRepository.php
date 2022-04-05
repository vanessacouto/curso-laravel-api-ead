<?php

namespace App\Repositories;

use App\Models\Support;
use App\Models\User;

class SupportRepository
{
    protected $entity;

    // no construtor, injeta o model que esse repository vai trabalhar
    // a partir dessa instancia do model, faremos nossas queries
    public function __construct(Support $model)
    {
        $this->entity = $model;
    }

    public function getSupports(array $filters = []) // recebe um array de filtros
    {
        return $this->getUserAuth()
            ->supports()
            // funcao de callback
            ->where(function ($query) use ($filters) {
                if (isset($filters['lesson'])) { // se no filtro for passado o parametro 'lesson'
                    $query->where('lesson_id', $filters['lesson']); // filtra pelo parametro passado
                }

                if (isset($filters['status'])) { // se no filtro for passado o parametro 'status'
                    $query->where('status', $filters['status']); // filtra pelo parametro passado
                }

                if (isset($filters['filter'])) { // se no filtro for passado o parametro 'filter'
                    $filter = $filters['filter'];
                    $query->where('description', 'LIKE', "%{$filter}%"); // filtra pelo parametro passado
                }
            })
            ->get();
    }

    public function createNewSupport(array $data): Support
    {
        // insere a partir do usuário autenticado
        $support = $this->getUserAuth()
            ->supports()
            ->create([
                'lesson_id' => $data['lesson'],
                'description' => $data['description'],
                'status' => $data['status'],
            ]);

        return $support;
    }


    // pegar usuário autenticado
    private function getUserAuth(): User
    {
        // quando tiver usuario autenticado
        //return auth()->user();

        return User::first();
    }
}
