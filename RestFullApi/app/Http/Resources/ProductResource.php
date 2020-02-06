<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ProductResource extends Resource
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
            'title' => $this->name,
            'details' => $this->description,
            'stock' =>  $this->quantity,
            'situation' => $this->status,
            'picture' => url("img/{$this->image}"),
            'seller' =>  $this->seller_id,
            'creationDate' => (string) $this->created_at,
            'lastChange' => (string) $this->updated_at,
            'deletedDate' => isset($this->deleted_at) ? $this->deleted_at : null,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('product.show', $this->id)
                ],
                [
                    'rel' => 'product.buyer.index',
                    'href' => route('product.buyer.index', $this->id)
                ],
                [
                    'rel' => 'product.category.index',
                    'href' => route('product.category.index', $this->id)
                ],
                [
                    'rel' => 'product.transaction.index',
                    'href' => route('product.transaction.index', $this->id)
                ],
                [
                    'rel' => 'sellers.show',
                    'href' => route('sellers.show', $this->seller_id)
                ],
            ]
        ];
    }
    public static function originalAttribute($index)
    {
        $attribute = [
            'identifier' => 'id',
            'title' => 'name',
            'details' => 'description',
            'stock' =>  'quantity',
            'situation' => 'status',
            'picture' => 'image',
            'seller' =>  'seller_id',
            'creationDate' => 'created_at',
            'lastChange' => 'updated_at',
            'deletedDate' => 'deleted_at',
        ];
        return isset($attribute[$index]) ? $attribute[$index] : null;
    }
}
