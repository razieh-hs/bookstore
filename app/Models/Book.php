<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $guarded = [];
    public $incrementing = false;
    protected $keyType = 'string';

    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id', 'id');
    }
}