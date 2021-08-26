<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection as AnonymousResourceCollectionAlias;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PagesCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return AnonymousResourceCollectionAlias
     */
    public function toArray($request): AnonymousResourceCollectionAlias
    {
        return PageResource::collection($this->collection);
    }
}
