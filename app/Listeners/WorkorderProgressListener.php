<?php

namespace App\Listeners;

use App\Events\WorkOrderProgress;
use App\Repositories\WorkOrderLogRepository;
use App\Repositories\WorkOrderRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class WorkorderProgressListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(WorkOrderProgress $event)
    {
        $wo_repo = app(WorkOrderRepository::class);
        $wo_repo->update($event->work_order, ['start_at' => date('Y-m-d H:i:s'), 'start_by' => Auth::user()->id]);
        $this->createLog($event->work_order);
    }

    protected function createLog($workorder)
    {
        $log_repo = app(WorkOrderLogRepository::class);

        $log_repo->create([
            'work_order_id' => $workorder->id,
            'log' => __('workorder.progress-wo', ['name' => strtolower($workorder->name)])
        ]);
    }
}
