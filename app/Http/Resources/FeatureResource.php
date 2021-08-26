<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FeatureResource extends JsonResource
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
            'category_id'   => $this->category_id,
            'price'         => $this->price,
            'image'         => $this->image ? asset('uploads/'.$this->image): '',
            'type'          => $this->type,
            'status'        => $this->status,
           // 'created_at'    => $this->created_at?->format('Y-m-d'),
           // 'updated_at'    => $this->updated_at?->format('Y-m-d'),
            $this->mergeWhen($this->whenLoaded('translations'), ['translations' => FeatureTranslationResource::collection($this->translations)]),
            $this->mergeWhen($this->whenLoaded('options'), ['options' => OptionResource::collection($this->options)]),
            $this->mergeWhen($this->whenLoaded('items'), ['items' => ItemResource::collection($this->items)])

        ];
    }
}
