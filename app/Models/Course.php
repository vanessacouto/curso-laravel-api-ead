<?php

namespace App\Models;

use App\Models\Module;
use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory, UuidTrait;

    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $fillable = ['name', 'description', 'image'];

    public function modules() {
        return $this->hasMany(Module::class);
    }
}
