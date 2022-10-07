<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
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
        $price = $this->price;
        if ($this->price <= 0) {
            $price = 'Free';
        }
        $categorylist = [];
        foreach ($this->category as $ctgr) {
            $arr = [
                'course_id'     => $ctgr->id,
                'course_name'   => $ctgr->category_name,
            ];
            array_push($categorylist, $arr);
        }
        // return parent::toArray($request);
        return [
            'id'                => $this->id,
            'course_name'       => $this->course_name,
            'description'       => $this->description,
            'price'             => $price,
            'created_by'        => $this->user_c['fullname'],
            'created_at'        => $this->created_at->format('d-m-Y H:i:s'),
            'updated_by'        => $this->user_u['fullname'],
            'updated_at'        => $this->updated_at->format('d-m-Y H:i:s'),
            'category_count'    => $this->category->count(),
            'course'            => $categorylist
        ];
    }
}
