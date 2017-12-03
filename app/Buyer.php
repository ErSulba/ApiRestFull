<?php

namespace App;

use App\Transaction;

class Buyer extends User
{
    function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
