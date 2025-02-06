<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AssetMasterParameterUsageResource extends JsonResource
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
        $data['asset_parameter'] = new AssetMasterParameterResource($this->whenLoaded('asset_parameter'));
        $data['work_order_attachment'] = new WorkOrderAttachmentResource($this->whenLoaded('work_order_attachment'));
        $data['created_at'] = $this->created_at->format('Y-m-d H:i:s');
        $data['updated_at'] = $this->created_at->format('Y-m-d H:i:s');
        
        return $data;
    }
}
