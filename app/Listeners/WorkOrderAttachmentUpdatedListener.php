<?php

namespace App\Listeners;

use App\Events\WorkOrderAttachmentUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class WorkOrderAttachmentUpdatedListener
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
    public function handle(WorkOrderAttachmentUpdated $event)
    {
        //
    }
}
