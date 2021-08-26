<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FaqResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $translation = $this->translations->first();

        return [
            'id'            => $this->id,
            'title'         => $translation->title ?? '',
            'short_summary' => $translation->short ?? '',
            'description'   => $translation->description ?? '',
            'image'         => $this->image ? asset('/uploads/'.$this->image) : '',
            'order'         => $this->order,
            'status'        => $this->status,
           // 'created_at'    => $translation->created_at?->format('Y-m-d'),
          //  'updated_at'    => $translation->updated_at?->format('Y-m-d')
        ];
    }
}
