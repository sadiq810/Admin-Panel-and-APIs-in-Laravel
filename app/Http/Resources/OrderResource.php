<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'id'            => $this->id,
            'customer_id'   => $this->customer_id,
            'quantity'      => $this->quantity,
            'total'         => $this->total,
            'status'        => $this->status,
            'date'          => $this->created_at?->format('Y-m-d h:m:s A'),
            //'created_at'    => $this->created_at?->format('Y-m-d h:m:s A'),
            //'updated_at'    => $this->updated_at?->format('Y-m-d h:m:s A'),
            $this->mergeWhen($this->whenLoaded('detail'), [
                'detail' => OrderDetailResource::collection($this->detail)
            ])
        ];
    }
}
