<?php

namespace App\Repositories\Eloquent;

use App\Events\UserWasCreated;
use App\Models\User;
use App\Repositories\LocationInstallationRepository;
use App\Repositories\LocationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EloquentLocationInstallationRepository extends EloquentBaseRepository implements LocationInstallationRepository
{

    public function list(array $params)
    {
        $location_installations = $this->model;

        if(isset($params['search'])) {
            $location_installations = $location_installations->where(function($query) use ($params) {
                $query->where('name' , 'like' , '%'.$params['search'].'%');
            });
        }

        if(isset($params['relations'])) {
            $relations = explode(',', $params['relations']);
            $location_installations = $location_installations->with($relations);
        }

        if(isset($params['location_id'])) {
            $location_installations = $location_installations->where('location_id', $params['location_id']);;
        }

        if (isset($params['pompa_id'])) {
            $location_installations = $location_installations->where('pompa_id', $params['pompa_id']);
        }

        if (isset($params['status'])) {
            $location_installations = $location_installations->where('status' , $params['status']);
        }

        if (isset($params['order_by']) && isset($params['order'])) {
            $order = $params['order'] == 'ascending' ? 'asc' : 'desc';
            $location_installations = $location_installations->orderBy($params['order_by'], $order);
        } else {
            $location_installations = $location_installations->orderBy('id', 'desc');
        }

        if(isset($params['per_page'])){
            return $location_installations->paginate($params['per_page']);
        }

        return $location_installations->get();
    }

    public function historyPompaList(array $params)
    {
        $datas =  $this->model

            ->select([
                'location_installations.*',
                'b.before', 
                'b.after', 
                'b.capacity', 
                'b.selisih',
                'b.work_order_attachment_id'
            ])

            ->leftJoin(
                DB::raw('
                    (
                        SELECT * FROM history_pompas WHERE history_pompas.id in (
                            SELECT max(id) FROM history_pompas as sub_history group by sub_history.location_installation_id
                        )
                    ) as  b
                '),

                'b.location_installation_id', 
                'location_installations.id'
            );

            if(isset($params['relations'])) {
                $relations = explode(',', $params['relations']);
                $datas = $datas->with($relations);
            }
    
            if(isset($params['location_id'])) {
                $datas = $datas->where('location_id', $params['location_id']);;
            }
    
            if (isset($params['pompa_id'])) {
                $datas = $datas->where('pompa_id', $params['pompa_id']);
            }

            if (isset($params['jenis_pompa'])) {
                $datas = $datas->where('jenis_pompa', $params['jenis_pompa']);
            }
    
            if (isset($params['status'])) {
                $datas = $datas->where('status' , $params['status']);
            }

            if (isset($params['order_by']) && isset($params['order'])) {
                $order = $params['order'] == 'ascending' ? 'asc' : 'desc';
                $datas = $datas->orderBy($params['order_by'], $order);
            } else {
                $datas = $datas->orderBy('id', 'desc');
            }

            if(isset($params['search'])) {
                $datas = $datas->where(function($query) use ($params) {
                    $query->where('name' , 'like' , '%'.$params['search'].'%');
                });
            }

        if(isset($params['per_page'])) {
            return $datas->paginate($params['per_page']);
        }

        return $datas->get();

        
    }
    
}
