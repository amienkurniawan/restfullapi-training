<?php

namespace App;

use App\Transaction;

class Buyer extends User
{
    /**
     * function relationship buyer one-to-many transaction 
     */
    public function transactions()
    {
        return  $this->hasMany(Transaction::class);
    }
}
