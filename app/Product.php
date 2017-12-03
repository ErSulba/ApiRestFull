<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;
use App\Seller;

class Product extends Model
{
    const PRODUCTO_DISPONIBLE = 'disponible';
    const PRODUCTO_NO_DISPONIBLE = 'no disponible';
    protected $fillable = [
        'name',
        'description',
        'quantity',
        'status',
        'image',
        'seller_id',
    ];

    function estaDisponible()
    {
        return $this->status == Product::PRODUCTO_DISPONIBLE;
    }

    function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
