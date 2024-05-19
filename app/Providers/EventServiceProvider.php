<?php

namespace App\Providers;

use App\Events\TaskCreated;
use App\Events\WorkOrderAttachmentCreated;
use App\Events\WorkOrderAttachmentUpdated;
use App\Events\WorkorderCreated;
use App\Events\WorkOrderFinished;
use App\Events\WorkOrderPending;
use App\Events\WorkOrderProgress;
use App\Events\WorkorderUpdated;
use App\Listeners\TaskCreatedListener;
use App\Listeners\WorkOrderAttachmentCreatedListener;
use App\Listeners\WorkOrderAttachmentUpdatedListener;
use App\Listeners\WorkorderCreatedListener;
use App\Listeners\WorkorderFinishListener;
use App\Listeners\WorkorderProgressListener;
use App\Listeners\WorkorderUpdatedListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        WorkorderCreated::class => [
            WorkorderCreatedListener::class,
        ],
        WorkorderUpdated::class => [
            WorkorderUpdatedListener::class,
        ],
        WorkOrderProgress::class => [
            WorkorderProgressListener::class,
        ],
        WorkOrderFinished::class => [
            WorkorderFinishListener::class,
        ],
        WorkOrderPending::class => [
            
        ],

        TaskCreated::class => [
            TaskCreatedListener::class
        ],

        WorkOrderAttachmentCreated::class => [
            WorkOrderAttachmentCreatedListener::class
        ],

        WorkOrderAttachmentUpdated::class => [
            WorkOrderAttachmentUpdatedListener::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
