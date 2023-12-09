<?php

namespace App\Listeners;

use App\Events\TaskCreated;
use App\Models\Task;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Milon\Barcode\DNS2D;
use Illuminate\Support\Str;

class TaskCreatedListener
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
    public function handle( TaskCreated $event)
    {
        $this->generateQrcode($event->task);   
    }

    protected function generateQrcode(Task $task)
    {
        $d = new DNS2D();
        $data = $d->getBarcodePNG(route('work-order.scan') . '?task_id=' . $task->id, 'QRCODE', 25, 25);

        $task->addMediaFromBase64($data)->usingFileName(Str::uuid())->toMediaCollection('barcode');
    }
}
