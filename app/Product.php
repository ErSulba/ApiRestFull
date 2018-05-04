<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;
use App\Seller;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int seller_id
 * @property mixed status
 * @property mixed transactions
 * @property mixed categories
 * @property mixed quantity
 * @property mixed id
 */
class Product extends Model
{
    use SoftDeletes;

    protected $dates = ['delete_at'];

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

    protected $hidden = [
        'pivot'
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
