<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        hash('sha256', strtolower(trim($this->email)));
        $user = parent::toArray($request);
        $user['roles'] = RoleTransformer::collection($this->whenLoaded('roles'));
        $user['created_at'] = $this->created_at->format('Y-m-d H:i:s');
        $user['updated_at'] = $this->updated_at->format('Y-m-d H:i:s');
        $user['default_profile'] = 'https://gravatar.com/avatar/' . hash('sha256', strtolower(trim($this->email))).'?d=identicon';
        return $user;
    }
}
