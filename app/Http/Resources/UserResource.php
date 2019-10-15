<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var \App\User|$this $this */
        return [
            'user' => [
                'id' => $this->id,
                'name' => $this->name,
                'email' => $this->email,
                'avatar' => asset(\Storage::url($this->avatar)),
                'roles' => RoleResource::collection($this->whenLoaded('roles')),
                'permissions' => PermissionResource::collection($this->getPermissionsViaRoles())
            ]
        ];
    }
}
