<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransactionSellerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\Transaction $transaction
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Transaction $transaction)
    {
        $seller = $transaction->product->seller;

        return $this->showOne($seller);
    }
}
