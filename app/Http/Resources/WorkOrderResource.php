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

        $data['work_order_items'] = WorkOrderItemResource::collection($this->whenLoaded('work_order_items'));
        $data['priority'] = new PriorityResource($this->whenLoaded('priority'));
        $data['location'] = new LocationResource($this->whenLoaded('location'));
        $data['task_category'] = new TaskCategoryResource($this->whenLoaded('task_category'));
        $data['user_finished'] = new UserTransformer($this->whenLoaded('user_finished'));
        $data['user_started'] = new UserTransformer($this->whenLoaded('user_started'));
        $data['user_created'] = new UserTransformer($this->whenLoaded('user_created'));
        $data['assignees'] = WorkOrderAssigneeResource::collection($this->whenLoaded('assignees'));
        $data['work_order_logs'] = WorkOrderLogResource::collection($this->whenLoaded('work_order_logs'));

        return $data;
    }
}
