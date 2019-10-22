<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArtistResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var \App\Artist|$this $this */
        return array_merge(parent::toArray($request), [
            'id' => $this->id,
            'name' => $this->name,
            'avatar' => asset(\Storage::url($this->avatar))
        ]);
    }
}
