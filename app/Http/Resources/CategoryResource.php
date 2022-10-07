<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $courselist = [];
        foreach ($this->course as $crs) {
            $price = $crs->price;
            if ($crs->price <= 0) {
                $price = 'Free';
            }
            $arr = [
                'course_id'     => $crs->id,
                'course_name'   => $crs->course_name,
                'description'   => $crs->description,
                'price'         => $price
            ];
            array_push($courselist, $arr);
        }
        // return parent::toArray($request);
        return [
            'id'            => $this->id,
            'category_name' => $this->category_name,
            'created_by'    => $this->user_c['fullname'],
            'created_at'    => $this->created_at->format('d-m-Y H:i:s'),
            'updated_by'    => $this->user_u['fullname'],
            'updated_at'    => $this->updated_at->format('d-m-Y H:i:s'),
            'course_count'  => $this->course->count(),
            'course'        => $courselist
        ];
    }
}
