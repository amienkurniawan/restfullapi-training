<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class CategoryResource extends Resource
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
            'title' => $this->name,
            'details' => $this->description,
            'creationDate' => (string) $this->created_at,
            'lastChange' => (string) $this->updated_at,
            'deletedDate' => isset($this->deleted_at) ? $this->deleted_at : null,
            'links' => [
                [
                    'rel' => 'categories.show',
                    'href' => route('categories.show', $this->id)
                ],
                [
                    'rel' => 'categories.product.index',
                    'href' => route('categories.product.index', $this->id)
                ],
                [
                    'rel' => 'categories.seller.index',
                    'href' => route('categories.seller.index', $this->id)
                ],
                [
                    'rel' => 'categories.transaction.index',
                    'href' => route('categories.transaction.index', $this->id)
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
            'creationDate' =>  'created_at',
            'lastChange' => 'updated_at',
            'deletedDate' => 'deleted_at',
        ];
        return isset($attribute[$index]) ? $attribute[$index] : null;
    }
}
