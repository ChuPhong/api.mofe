<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SongResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var \App\Song|$this $this */
        return [
            'song' => array_merge(parent::toArray($request), [
                'thumbnail' => asset(\Storage::url($this->thumbnail)),
                'url' => asset(\Storage::url($this->url)),
                'artists' => ArtistResource::collection($this->whenLoaded('artists'))
            ])
        ];
    }
}
