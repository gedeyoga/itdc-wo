<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateWorkOrderRequest;
use App\Http\Requests\UpdateWorkOrderRequest;
use App\Http\Resources\WorkOrderResource;
use App\Models\WorkOrder;
use App\Repositories\WorkOrderRepository;
use Illuminate\Http\Request;

class WorkOrderController extends Controller
{
    protected $workorder_repo;

    public function __construct()
    {
        $this->workorder_repo = app(WorkOrderRepository::class);    
    }

    public function list(Request $request)
    {

        $work_orders = $this->workorder_repo->list($request->all());
        return WorkOrderResource::collection($work_orders);
        
    }

    public function store(CreateWorkOrderRequest $request)
    {
        $data = $request->except('work_order_items');
        $items = $request->only('work_order_items');

        $work_order = $this->workorder_repo->createWorkOrder($data, $items);

        return response()->json([
            'message' => 'Success Create Work Order',
            'data' => new WorkOrderResource($work_order)
        ]);
    }

    public function update(WorkOrder $work_order, UpdateWorkOrderRequest $request)
    {
        $data = $request->except('work_order_items');
        $items = $request->only('work_order_items');

        $work_order = $this->workorder_repo->updateWorkOrder( $work_order, $data, $items);

        return response()->json([
            'message' => 'Success Update Work Order',
            'data' => new WorkOrderResource($work_order)
        ]);
    }

    public function show(WorkOrder $work_order)
    {
        return new WorkOrderResource($work_order->load(['work_order_items' , 'priority' , 'task_category', 'start_by' , 'finish_by']));
    }

    public function destroy(WorkOrder $work_order)
    {
        $this->workorder_repo->destroy($work_order);

        return response()->json([
            'message' => 'Delete work order success'
        ]);
    }

    public function updateStatus(WorkOrder $work_order, Request $request)
    {
        $request->validate([
            'status' => ['required', 'string']
        ]);

        $task_count = $work_order->work_order_items->count();
        $task_finish_count = $work_order->work_order_items()->where('status' , 'finish')->count();

        if($request->get('status') == 'finish') {
            if ($task_count  != $task_finish_count) {
                return response()->json([
                    'message' => 'Please complete all task before finish'
                ], 422);
            }
        }

        $this->workorder_repo->statusChanged($work_order, $request->get('status'));

        return response()->json([
            'message' => 'Status work order ' . $request->get('status'),
        ]);
    }


}
