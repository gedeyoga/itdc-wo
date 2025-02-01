<?php

namespace App\Repositories\Eloquent;

use App\Events\UserWasCreated;
use App\Models\HistoryPompa;
use App\Models\User;
use App\Repositories\HistoryPompaRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function historyPompaByLocations($location_installation_id, array $params = [])
    {
        return $this->model
            ->where('location_installation_id' , $location_installation_id)
            ->when(isset($params['relations']) , function($q) use($params) {
                $relations = explode(',', $params['relations']);
                return $q->with($relations);
            })
            ->when(isset($params['periode']) , function($q) use($params) {
                return $q->whereBetween('created_at' , [
                    date('Y-m-01 00:00:00' , strtotime($params['periode'])),
                    date('Y-m-t 23:59:59' , strtotime($params['periode'])),
                ]);
            })
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
            ->get();
    }
}
