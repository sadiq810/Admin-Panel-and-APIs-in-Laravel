<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OptionTranslationResource extends JsonResource
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
            'feature_option_id' => $this->feature_option_id,
            'language_id'       => $this->language_id,
            'title'             => $this->title,
            'description'       => $this->description,
           // 'created_at'        => $this->created_at?->format('Y-m-d'),
           // 'updated_at'        => $this->updated_at?->format('Y-m-d')
        ];
    }
}
