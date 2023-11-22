<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WorkOrderResource extends JsonResource
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

        $data['created_at'] = $this->created_at->format('Y-m-d H:i:s');
        $data['updated_at'] = $this->updated_at->format('Y-m-d H:i:s');

        $data['work_order_items'] = WorkOrderItemResource::collection($this->whenLoaded('Work_order_items'));
        $data['priority'] = new PriorityResource($this->whenLoaded('priority'));
        $data['task_category'] = new TaskCategoryResource($this->whenLoaded('task_category'));
        $data['finish_by'] = new UserTransformer($this->whenLoaded('finish_by'));
        $data['start_by'] = new UserTransformer($this->whenLoaded('start_by'));

        return $data;
    }
}
