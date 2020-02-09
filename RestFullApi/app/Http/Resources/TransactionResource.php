<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class TransactionResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'identifier' =>  $this->id,
            'quantity' =>  $this->quantity,
            'buyer' =>  $this->buyer_id,
            'product' =>  $this->product_id,
            'creationDate' => (string) $this->created_at,
            'lastChange' => (string) $this->updated_at,
            'deletedDate' => isset($this->deleted_at) ? $this->deleted_at : null,
            'links' => [
                [
                    'rel' => 'transactions.show',
                    'href' => route('transactions.show', $this->id)
                ],
                [
                    'rel' => 'transactions.category.index',
                    'href' => route('transactions.category.index', $this->id)
                ],
                [
                    'rel' => 'transactions.sellers.index',
                    'href' => route('transactions.seller.index', $this->id)
                ],
                [
                    'rel' => 'product.show',
                    'href' => route('product.show', $this->product_id)
                ],
                [
                    'rel' => 'buyers.show',
                    'href' => route('buyers.show', $this->buyer_id)
                ],
            ]
        ];
    }
    public static function originalAttribute($index)
    {
        $attribute = [
            'identifier' =>  'id',
            'quantity' =>  'quantity',
            'buyer' =>  'buyer_id',
            'product' =>  'product_id',
            'creationDate' =>  'created_at',
            'lastChange' =>  'updated_at',
            'deletedDate' => 'deleted_at',
        ];
        return isset($attribute[$index]) ? $attribute[$index] : null;
    }
    public static function transformedAttribute($index)
    {
        $attribute = [
            'id' => 'identifier',
            'quantity' => 'quantity',
            'buyer_id' => 'buyer',
            'product_id' => 'product',
            'created_at' => 'creationDate',
            'updated_at' => 'lastChange',
            'deleted_at' => 'deletedDate',
        ];
        return isset($attribute[$index]) ? $attribute[$index] : null;
    }
}
