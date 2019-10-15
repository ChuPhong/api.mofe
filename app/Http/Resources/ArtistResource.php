<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArtistResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var \App\Artist|$this $this */
        return [
            'name' => $this->name,
            $this->mergeWhen($this->avatar, [
                'avatar' => $this->avatar
            ])
        ];
    }
}
