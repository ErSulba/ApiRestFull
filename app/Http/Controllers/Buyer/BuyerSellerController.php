<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BuyerSellerController extends ApiController
{
    /**
     * Display a listing of the product sellers for a given buyer
     *
     * @param \App\Buyer $buyer
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Buyer $buyer)
    {
        $sellers= $buyer->transactions()->with('product.seller')
            ->get()
            ->pluck('product.seller')
            ->unique("id")
            ->values();

        return $this->showAll($sellers);
    }

}
