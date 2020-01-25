<?php

namespace RestFullAPIAmien;

use RestFullAPIAmien\Scopes\BuyerScopes;
use RestFullAPIAmien\Transaction;
use Illuminate\Database\Eloquent\SoftDeletes;

class Buyer extends User
{


    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new BuyerScopes);
    }
    /**
     * function relationship buyer one-to-many transaction 
     */
    public function transactions()
    {
        return  $this->hasMany(Transaction::class);
    }
}
