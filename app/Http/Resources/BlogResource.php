<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
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
            'slug'              => $this->slug,
            'title'             => $translation->title ?? '',
            'summary'           => $translation->summary ?? '',
            'description'       => $translation->description ?? '',
            'seo_keywords'      => $translation->seo_keywords ?? '',
            'seo_description'   => $translation->seo_description ?? '',
            'image'             => $this->image ? asset('uploads/'.$this->image) : '',
            'status'            => $this->status,
            'views'             => $this->views,
            'created_at'        => $translation?->created_at?->format('Y-m-d'),
            'updated_at'        => $translation?->updated_at?->format('Y-m-d'),


        ];
    }
}
