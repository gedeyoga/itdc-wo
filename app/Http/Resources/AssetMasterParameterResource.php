<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AssetMasterParameterResource extends JsonResource
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
        $data['asset_master'] = new AssetMasterResource($this->whenLoaded('asset_master'));
        $data['asset_usages'] = AssetMasterParameterUsageResource::collection($this->whenLoaded('asset_usages'));
        $data['created_at'] = $this->created_at->format('Y-m-d H:i:s');
        $data['updated_at'] = $this->created_at->format('Y-m-d H:i:s');
        
        return $data;
    }
}
