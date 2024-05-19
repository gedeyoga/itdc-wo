<?php

namespace App\Jobs;

use App\Models\TaskSchedule;
use App\Repositories\WorkOrderAssigneeRepository;
use App\Repositories\WorkOrderRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateWorkOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $taskSchedule;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(TaskSchedule $taskSchedule)
    {
        $this->taskSchedule = $taskSchedule;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $work_order_repo = app(WorkOrderRepository::class);
        $workorder_assignee_repo = app(WorkOrderAssigneeRepository::class);

        $work_order = [
            'name' => $this->taskSchedule->task->name, 
            'description' => $this->taskSchedule->task->description, 
            'task_category_id' => $this->taskSchedule->task->task_category_id, 
            'priority_id' => $this->taskSchedule->task->priority_id, 
            'date' => date('Y-m-d H:i:s'), 
            'created_by' => $this->taskSchedule->created_by, 
            'location_id' => $this->taskSchedule->task->location_id,
            'fill_history_pompa' =>  $this->taskSchedule->task->fill_history_pompa,
            'work_order_attachments' => $this->taskSchedule->task->task_attachments->map(function($item) {
                return $item->attach_id . ':' . $item->attach_type;
            })->toArray(),
        ];

        $work_order_items = $this->taskSchedule->task->task_items->map(function($item) {
            return [
                'name' => $item->name,
                'has_media' => $item->has_media,
            ];
        })->toArray();

        $assignees =  $this->taskSchedule->users->map(fn($item) => ['user_id' => $item->user_id])->toArray();

        $data = $work_order_repo->createWorkOrder($work_order,  $work_order_items);
        $workorder_assignee_repo->assgineeWorkOrder($data, $assignees);
        
    }
}
