<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['order_id', 'book_id', 'title', 'author', 'price', 'quantity', 'cover'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}