<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskScheduleResource extends JsonResource
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
        $data['days'] = $this->whenLoaded('days');
        $data['months'] = $this->whenLoaded('months');
        $data['years'] = $this->whenLoaded('years');
        $data['created_at'] = $this->created_at->format('Y-m-d H:i:s');
        $data['updated_at'] = $this->updated_at->format('Y-m-d H:i:s');
        $data['created_user'] = new UserTransformer($this->whenLoaded('created_user'));
        $data['updated_user'] = new UserTransformer($this->whenLoaded('updated_user'));
        $data['users'] = $this->whenLoaded('users');

        return $data;
    }
}
