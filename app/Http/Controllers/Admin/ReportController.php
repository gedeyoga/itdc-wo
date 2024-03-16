<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\LocationResource;
use App\Http\Resources\UserTransformer;
use App\Repositories\WorkOrderRepository;
use Illuminate\Http\Request;
use PDF;

class ReportController extends Controller
{

    protected $work_order_repo;

    public function __construct()
    {
        $this->work_order_repo = app(WorkOrderRepository::class);
    }

    public function daily()
    {
        return view('layouts.main');
    }

    public function monthly()
    {
        return view('layouts.main');
    }

    public function reportDailyPdf(Request $request)
    {
        $params['dates'] = [
            date('Y-m-d', strtotime($request->get('dates')[0])) . ' '  . '00:00:00',
            date('Y-m-d', strtotime($request->get('dates')[1])) . ' ' . '23:59:59',
        ];

        $report_data = $this->work_order_repo->reportWorkOrderDaily($params);


        $pdf = PDF::set_option("enable_remote", true)->loadView('reports.daily-wo', [
            'group_status' => $report_data['group_status'],
            'group_assignees' => UserTransformer::collection($report_data['group_assignees']),
            'group_locations' => LocationResource::collection($report_data['group_locations'])
        ]);

        return $pdf->stream();
    }
}
