<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Http\Requests\ProductBuyerStore;
use App\Product;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProductBuyerTransactionController extends ApiController
{

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductBuyerStore $request
     * @param Product $product
     * @param User $buyer
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(ProductBuyerStore $request, Product $product, User $buyer)
    {
        if ($buyer->id == $product->seller_id) {
            return $this->errorResponse('El comprador debe ser diferente al vendedor', 409);
        }

        if ($buyer->esverificado()) {
            return $this->errorResponse('El comprador debe ser un usuario verificado', 409);
        }

        if (!$product->seller->esVerificado()) {
            return $this->errorResponse('El vededor debe ser un usuario verificado', 409);

        }

        if ($product->quantity < $request->quantity){
            return $this->errorResponse('El producto no tiene la cantidad disponible en estos momentos', 409);

        }

        return DB::transaction(function () use ($request, $product, $buyer) {
            $product->quantity -= $request->quantity;
            $product->save();

            $transaction = Transaction::create([
                'quantity' => $request->quantity,
                'buyer_id' => $buyer->id,
                'product_id' => $product->id,
            ]);

            return $this->showOne($transaction, 201);
        });
    }


}
