<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
        $data['priority'] = new PriorityResource($this->whenLoaded('priority'));
        $data['task_category'] = new PriorityResource($this->whenLoaded('task_category'));
        $data['task_attachments'] = $this->whenLoaded('task_attachments');
        $data['task_items'] = new TaskItemResource($this->whenLoaded('task_items'));
        $data['barcode'] = $this->getMedia('barcode')->count() == 1 ? $this->getMedia('barcode')->first() : null;
        $data['created_at'] = $this->created_at->format('Y-m-d H:i:s');
        $data['updated_at'] = $this->updated_at->format('Y-m-d H:i:s');

        return $data;
        
    }
}
