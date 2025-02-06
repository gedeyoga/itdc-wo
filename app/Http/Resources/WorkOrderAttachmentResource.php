<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WorkOrderAttachmentResource extends JsonResource
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
        $data['work_order'] = new WorkOrderResource($this->whenLoaded('work_order'));

        $attach_types = [
            'location_installation' => new HistoryPompaResource($this->whenLoaded('history_pompa'))
        ];

        // $data['relation'] = $attach_types[$this->attach_type];

        return $data;
    }
}
