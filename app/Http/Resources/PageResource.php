<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        $translation = $this->translations->first();

        return [
            'id'                => $this->id,
            'language_id'       => $translation->language_id ?? '',
            'slug'              => $this->slug,
            'title'             => $translation->title ?? '',
            'content'           => $translation->content ?? '',
            'seo_keywords'      => $translation->seo_keywords ?? '',
            'seo_description'   => $translation->seo_description ?? '',
            'type'              => $this->type,
            'status'            => $this->status,
            'created_at'        => $translation?->created_at?->format('Y-m-d'),
            'updated_at'        => $translation?->updated_at?->format('Y-m-d'),
        ];
    }
}
