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
            'situation' => $this->status,
            'seller' =>  $this->seller_id,
            'creationDate' => (string) $this->created_at,
            'lastChange' => (string) $this->updated_at,
            'deletedDate' => isset($this->deleted_at) ? $this->deleted_at : null,
        ];
    }
}
