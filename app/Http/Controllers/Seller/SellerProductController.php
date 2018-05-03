<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Http\Requests\ProductStore;
use App\Http\Requests\ProductUpdate;
use App\Product;
use App\Seller;
use App\User;
use Symfony\Component\HttpKernel\Exception\HttpException;


class SellerProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param Seller $seller
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Seller $seller)
    {
        $products = $seller->products;
        return $this->showAll($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductStore $request
     * @param User $seller
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ProductStore $request, User $seller)
    {
        $data = $request->all();
        $data['status']= Product::PRODUCTO_NO_DISPONIBLE;
        $data['image']='1.jpg';
        $data['seller_id'] = $seller->id;

        $product = Product::create($data);

        return $this->showOne($product, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductUpdate $request
     * @param  \App\Seller $seller
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ProductUpdate $request, Seller $seller, Product $product)
    {

        $this->verifySeller($seller, $product);

        $product->fill($request->only([
            'name',
            'description',
            'quantity'
        ]));

        if ($request->has('status')) {
            $product->status = $request->status;

            if ($product->estaDisponible() && $product->categories()->count() ==0 ) {
                return $this->errorResponse('Un producto activo debe tener al menos una categoria', 409);
            }
        }

        if ($product->isClean()) {
            return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar', 422);
        }

        $product->save();

        return $this->showOne($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Seller $seller
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Seller $seller, Product $product)
    {
        $this->verifySeller($seller, $product);
        $product->delete();

        return $this->showOne($product);

    }

    /**
     * Verify that the current user is the owner of the product
     *
     * @param Seller $seller
     * @param Product $product
     */
    protected function verifySeller(Seller $seller, Product $product)
    {
        if ($seller->id != $product->seller_id){
            throw new HttpException(422, 'Error Processing Request');
        }
    }
}
