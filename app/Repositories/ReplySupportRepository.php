<?php

namespace App\Repositories;

use App\Models\ReplySupport;
use App\Repositories\Traits\RepositoryTrait;

class ReplySupportRepository
{
    use RepositoryTrait;

    protected $entity;

    // no construtor, injeta o model que esse repository vai trabalhar
    // a partir dessa instancia do model, faremos nossas queries
    public function __construct(ReplySupport $model)
    {
        $this->entity = $model;
    }

    public function createReplyToSupport(array $data)
    {
        $user = $this->getUserAuth();

        $reply = $this->entity
            ->create([
                'support_id' => $data['support_id'],
                'description' => $data['description'],
                'user_id' => $user->id,
            ]);

        return $reply;

        // dessa forma cria acoplamento entre repositories
        //$support = app(SupportRepository::class)->getSupport($supportId); // cria uma instancia da classe 'SupportRepository'
        // $reply = $support
        //             ->replies()
        //             ->create([
        //                 'description' => $data['description'],
        //                 'user_id' => $user->id,
        //             ]);
    }
}
