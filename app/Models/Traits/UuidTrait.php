<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

trait UuidTrait
{
    public static function booted()
    {
        // antes de criar um usuario, vai gerar um id
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Str::uuid();
        });
    }
}
