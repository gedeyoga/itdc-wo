<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReportSummaryDailyRequest;
use App\Http\Resources\LocationResource;
use App\Http\Resources\UserTransformer;
use App\Repositories\WorkOrderRepository;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    protected $work_order_repo;

    public function __construct()
    {
        $this->work_order_repo = app(WorkOrderRepository::class);    
    }
    public function reportSummaryDaily(ReportSummaryDailyRequest $request)
    {
        $params['dates'] = [
            date('Y-m-d' , strtotime($request->get('dates')[0])) . ' '  . '00:00:00',
            date('Y-m-d' , strtotime($request->get('dates')[1])) . ' ' . '23:59:59',
        ];

        $report_data = $this->work_order_repo->reportWorkOrderDaily($params);

        return response()->json([
            'group_status' => $report_data['group_status'],
            'group_assignees' => UserTransformer::collection($report_data['group_assignees']),
            'group_locations' => LocationResource::collection($report_data['group_locations'])
        ]);


    }

    public function reportWorkorderMontly(Request $request)
    {
        $datas = $this->work_order_repo->reportWorkOrderMonthly($request->all());

        return UserTransformer::collection($datas);
    }
}
