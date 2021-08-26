<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OptionResource extends JsonResource
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
            'feature_id'    => $this->feature_id,
            'title'         => $this->title,
            'description'   => $this->description,
            'type'          => $this->type,
            'icon'          => $this->icon ? asset('uploads/'.$this->icon) : '',
          //  'created_at'    => $this->created_at?->format('Y-m-d'),
         //   'updated_at'    => $this->updated_at?->format('Y-m-d'),
            $this->mergeWhen($this->whenLoaded('translations'), [
                'translations' => OptionTranslationResource::collection($this->translations)
            ])
        ];
    }
}
