<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class UserResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return
            [
                'identifier' =>  $this->id,
                'name' => $this->name,
                'email' => $this->email,
                'isVerified' =>  $this->verified,
                'isAdmin' => ($this->admin === "true"),
                'creationDate' => (string) $this->created_at,
                'lastChange' => (string) $this->updated_at,
                'deletedDate' => isset($this->deleted_at) ? $this->deleted_at : null,

            ];
    }

    public static function originalAttribute($index)
    {
        $attribute = [
            'identifier' =>  'id',
            'name' => 'name',
            'email' => 'email',
            'isVerified' =>  'verified',
            'isAdmin' => 'admin',
            'creationDate' => 'created_at',
            'lastChange' => 'updated_at',
            'deletedDate' => 'deleted_at',
        ];
        return isset($attribute[$index]) ? $attribute[$index] : null;
    }
}
