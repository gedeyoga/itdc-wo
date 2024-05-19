<?php

namespace App\Events;

use App\Models\WorkOrderAttachment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WorkOrderAttachmentCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $work_order_attachment;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(WorkOrderAttachment $workOrderAttachment)
    {
        $this->work_order_attachment = $workOrderAttachment;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
