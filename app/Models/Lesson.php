<?php

namespace App\Models;

use App\Models\View;
use App\Models\Support;
use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lesson extends Model
{
    use HasFactory, UuidTrait;

    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $fillable = ['name', 'description', 'video'];

    public function supports()
    {
        return $this->hasMany(Support::class);
    }

    public function views()
    {
        return $this->hasMany(View::class)
            ->where(function ($query) {
                // só aplica esse 'where' se o usuário estiver autenticado
                if (auth()->check()) {
                    // quando usuário está logado só exibe o total de visualizações do usuário e não o total geral de visualizações por todos da plataforma
                    return $query->where('user_id', auth()->user()->id);
                }
            });
    }
}
