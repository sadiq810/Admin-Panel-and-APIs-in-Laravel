<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'                => $this->id,
            //'order_id'          => $this->order_id,
            'feature_id'        => $this->feature_id,
            'feature_items'     => $this->feature_items,
            'feature_options'   => $this->feature_options,
            'price'             => $this->price,
            //'payload'           => $this->payload,
            'status'            => $this->status,
           // 'created_at'        => $this->created_at?->format('Y-m-d h:i:s A'),
           // 'updated_at'        => $this->updated_at?->format('Y-m-d h:i:s A'),
        ];
    }
}
