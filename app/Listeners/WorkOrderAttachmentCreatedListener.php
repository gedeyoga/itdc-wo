<?php

namespace App\Listeners;

use App\Events\WorkOrderAttachmentCreated;
use App\Models\AssetMaster;
use App\Models\LocationInstallation;
use App\Repositories\AssetMasterParameterUsageRepository;
use App\Repositories\AssetMasterRepository;
use App\Repositories\HistoryPompaRepository;
use App\Repositories\LocationInstallationRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class WorkOrderAttachmentCreatedListener
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
    public function handle(WorkOrderAttachmentCreated $event)
    {
        $work_order_attachment = $event->work_order_attachment;

        $history_pompa_repo = app(HistoryPompaRepository::class);
        $asset_usage_repo = app(AssetMasterParameterUsageRepository::class);


        $type_list = [
            'location_installation' => app(LocationInstallationRepository::class),
            'asset_master' => app(AssetMasterRepository::class),
        ];

        if(isset($type_list[$work_order_attachment->attach_type])) {
           $attach = $type_list[$work_order_attachment->attach_type]->find($work_order_attachment->attach_id);

           if($attach instanceof LocationInstallation) {
                $history_pompa_repo->create([
                    'location_installation_id' => $attach->id,
                    'work_order_attachment_id' => $work_order_attachment->id,
                    'before' => 0,
                    'after' => 0,
                    'selisih' => 0,
                    'capacity' => $attach->pompa->capacity,
                ]);
           }else if($attach instanceof AssetMaster) {
                foreach ($attach->asset_parameters as $parameter) {
                    $asset_usage_repo->create([
                        'asset_id' => $attach->id,
                        'asset_parameter_id' => $parameter->id,
                        'work_order_attachment_id' => $work_order_attachment->id,
                        'before' => 0,
                        'after' => 0,
                        'selisih' => 0,
                    ]);
                }
           }

        }


    }
}
