<?php

namespace App\Listeners;

use App\Events\WorkorderUpdated;
use App\Repositories\WorkOrderLogRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class WorkorderUpdatedListener
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
    public function handle(WorkorderUpdated $event)
    {
        $this->createLog($event->work_order);
    }

    protected function createLog($workorder)
    {
        $log_repo = app(WorkOrderLogRepository::class);

        $log_repo->create([
            'work_order_id' => $workorder->id,
            'log' => __('workorder.update-wo', ['name' => strtolower($workorder->name)])
        ]);
    }
}
