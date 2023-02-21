<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Organization extends Model
{
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($post) {
           $post->{$post->getKeyName()} = (string) Uuid::uuid4();
        });
    }

    protected $keyType = 'string';
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
