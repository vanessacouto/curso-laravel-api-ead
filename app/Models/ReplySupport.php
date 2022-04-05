<?php

namespace App\Models;

use App\Models\User;
use App\Models\Support;
use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReplySupport extends Model
{
    use HasFactory, UuidTrait;

    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $fillable = ['description', 'support_id', 'user_id'];

    protected $table = 'reply_support';

    protected $touches = ['support']; // indica qual relacionamento 'tocar': toda vez que alterar algo na resposta, vai 'tocar' o relacionamento 'support' (vai atualizar o timestamps de 'suppor')

    public function support()
    {
        return $this->belongsTo(Support::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
