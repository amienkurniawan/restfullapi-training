<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class BuyerResource extends Resource
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
            'identifier' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'isVerified' => $this->verified,
            'creationDate' => (string) $this->created_at,
            'lastChange' => (string) $this->updated_at,
            'deletedDate' => isset($this->deleted_at) ? $this->deleted_at : null,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('buyers.show', $this->id)
                ],
                [
                    'rel' => 'buyers.category.index',
                    'href' => route('buyers.category.index', $this->id)
                ],
                [
                    'rel' => 'buyers.category.product',
                    'href' => route('buyers.product.index', $this->id)
                ],
                [
                    'rel' => 'buyers.seller.index',
                    'href' => route('buyers.seller.index', $this->id)
                ],
                [
                    'rel' => 'buyers.transaction.index',
                    'href' => route('buyers.transaction.index', $this->id)
                ],
            ]
        ];
    }
    public static function originalAttribute($index)
    {
        $attribute = [
            'identifier' => 'id',
            'name' => 'name',
            'email' => 'email',
            'isVerified' => 'verified',
            'creationDate' => 'created_at',
            'lastChange' =>  'updated_at',
            'deletedDate' =>  'deleted_at',
        ];
        return isset($attribute[$index]) ? $attribute[$index] : null;
    }
}
