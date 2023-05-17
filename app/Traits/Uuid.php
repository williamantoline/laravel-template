<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait Uuid
{
    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($model) {
             if ($model->getKey() === null) {
                 $model->setAttribute($model->getKeyName(), Str::ulid()->toRfc4122());
             }
        });
    }

    public function getIncrementing(): bool
    {
        return false;
    }

    public function getKeyType(): string
    {
        return 'string';
    }
}