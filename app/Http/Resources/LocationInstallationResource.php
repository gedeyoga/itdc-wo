<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LocationInstallationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = parent::toArray($request);
        $data['type_relation'] = 'location_installation';
        $data['location'] = new LocationResource($this->whenLoaded('location'));
        $data['pompa'] = new PompaResource($this->whenLoaded('pompa'));

        return $data;
    }
}
