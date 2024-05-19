<?php

namespace App\Repositories\Eloquent;

use App\Events\UserWasCreated;
use App\Models\HistoryPompa;
use App\Models\User;
use App\Repositories\HistoryPompaRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class EloquentHistoryPompaRepository extends EloquentBaseRepository implements HistoryPompaRepository
{
    public function updateHistory(HistoryPompa $historyPompa, $meter_counter)
    {
        $latest_data = $this->model->where('location_installation_id' , $historyPompa->location_installation_id)->where('id' , '<>' , $historyPompa->id)->latest()->first();

        $before = !is_null($latest_data) ? $latest_data->after : 0;
        $after = $before + $meter_counter;

        $data = $this->update($historyPompa, [
            'before' => $before,
            'after' => $after,
            'selisih' => $after - $before,
            'capacity' => $historyPompa->location->pompa->capacity,
        ]);

        return $data;
    }
}
