<?php

namespace App\Repositories;

use App\Models\Support;
use App\Repositories\Traits\RepositoryTrait;

class SupportRepository
{
    use RepositoryTrait;

    protected $entity;

    // no construtor, injeta o model que esse repository vai trabalhar
    // a partir dessa instancia do model, faremos nossas queries
    public function __construct(Support $model)
    {
        $this->entity = $model;
    }

    public function getMySupports(array $filters = [])
    {
        // insere o filtro
        $filters['user'] = true;

        return $this->getSupports($filters);
    }

    public function getSupports(array $filters = []) // recebe um array de filtros
    {
        return //$this->getUserAuth() // usando com getUserAuth só vai retornar as 'dúvidas da aula' do usuário logado
            $this->entity
                    // funcao de callback
                    ->where(function ($query) use ($filters) {
                        if (isset($filters['lesson'])) { // se no filtro for passado o parametro 'lesson'
                            $query->where('lesson_id', $filters['lesson']); // filtra pelo parametro passado
                        }

                        if (isset($filters['status'])) { // se no filtro for passado o parametro 'status'
                            $query->where('status', $filters['status']); // filtra pelo parametro passado
                        }

                        if (isset($filters['user'])) {
                            $user = $this->getUserAuth();
                            $query->where('user_id', $user->id);
                        }

                        if (isset($filters['filter'])) { // se no filtro for passado o parametro 'filter'
                            $filter = $filters['filter'];
                            $query->where('description', 'LIKE', "%{$filter}%"); // filtra pelo parametro passado
                        }
                    })
                    ->with('replies')
                    ->orderBy('updated_at')
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

    // metodo que retorna um 'support' a partir de um 'id'
    private function getSupport(string $id)
    {
        // se nao encontrar o id, retorna erro 404
        return $this->entity->findOrFail($id);
    }
}
