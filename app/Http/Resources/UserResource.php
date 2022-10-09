<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        $profilepicture = $this->user_pp['image'] ? $this->user_pp['image'] : 'no picture found';
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'fullname'          => $this->fullname,
            'email'             => $this->email,
            'profile_picture'   => $profilepicture
        ];
    }
}
