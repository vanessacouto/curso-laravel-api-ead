<?php

namespace App\Models;

use App\Models\User;
use App\Models\Lesson;
use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Support extends Model
{
    use HasFactory, UuidTrait;

    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $fillable = ['status', 'description', 'lesson_id']; // o status vai ser um enum

    public $statusOptions = [
        'P' => 'Pendente, Aguardando Professor',
        'A' => 'Aguardando Aluno',
        'C' => 'Finalizado',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
