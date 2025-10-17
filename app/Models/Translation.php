<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Translation extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::saved(function ($model) {
            Cache::forget("translation.{$model->lang}.{$model->key}");
        });

        static::deleted(function ($model) {
            Cache::forget("translation.{$model->lang}.{$model->key}");
        });
    }
}
