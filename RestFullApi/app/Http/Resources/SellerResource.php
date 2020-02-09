<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class SellerResource extends Resource
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
                    'rel' => 'sellers.show',
                    'href' => route('sellers.show', $this->id)
                ],
                [
                    'rel' => 'sellers.buyer.index',
                    'href' => route('sellers.buyer.index', $this->id)
                ],
                [
                    'rel' => 'sellers.category.index',
                    'href' => route('sellers.category.index', $this->id)
                ],
                [
                    'rel' => 'sellers.products.index',
                    'href' => route('sellers.products.index', $this->id)
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
            'lastChange' => 'updated_at',
            'deletedDate' => 'deleted_at',
        ];
        return isset($attribute[$index]) ? $attribute[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attribute = [
            'id' => 'identifier',
            'name' => 'name',
            'email' => 'email',
            'verified' => 'isVerified',
            'created_at' => 'creationDate',
            'updated_at' => 'lastChange',
            'deleted_at' => 'deletedDate',
        ];
        return isset($attribute[$index]) ? $attribute[$index] : null;
    }
}
