<?php

namespace App\Http\Requests;

use App\Product;
use Illuminate\Foundation\Http\FormRequest;


/**
 * @property mixed status
 */
class ProductUpdate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'quantity' => 'integer|min:1',
            'status'    => 'in:' .Product::PRODUCTO_DISPONIBLE.','.Product::PRODUCTO_NO_DISPONIBLE,
            'image' => 'image'
        ];
    }
}
