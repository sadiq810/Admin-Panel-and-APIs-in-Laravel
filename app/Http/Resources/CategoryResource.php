<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'         => $this->category_id,
            'title'      => $this->title,
            'description'=> $this->description,
          //  'category_id'=> $this->category_id,
            'language_id'=> $this->language_id,
            'order'      => $this->category->order ?? '',
            'status'     => $this->category->status ?? '',
            'type'       => $this->category->type ?? '',
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s')
        ];
    }
}
