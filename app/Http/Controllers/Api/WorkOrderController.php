<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateWorkOrderRequest;
use App\Http\Requests\UpdateWorkOrderRequest;
use App\Http\Resources\WorkOrderItemResource;
use App\Http\Resources\WorkOrderResource;
use App\Models\WorkOrder;
use App\Repositories\WorkOrderAssigneeRepository;
use App\Repositories\WorkOrderItemRepository;
use App\Repositories\WorkOrderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkOrderController extends Controller
{
    protected $workorder_repo;
    protected $workorder_assignee_repo;
    protected $workorder_item_repo;

    public function __construct()
    {
        $this->workorder_repo = app(WorkOrderRepository::class);    
        $this->workorder_item_repo = app(WorkOrderItemRepository::class);    
        $this->workorder_assignee_repo = app(WorkOrderAssigneeRepository::class);    
    }

    public function list(Request $request)
    {

        $work_orders = $this->workorder_repo->list($request->all());
        return WorkOrderResource::collection($work_orders);
        
    }

    public function store(CreateWorkOrderRequest $request)
    {
        $data = $request->except('work_order_items');
        $items = $request->get('work_order_items' , []);
        $assingees = $request->get('assignees', []);

        DB::beginTransaction();
        try {
            $work_order = $this->workorder_repo->createWorkOrder($data, $items);
            $this->workorder_assignee_repo->assgineeWorkOrder($work_order, $assingees);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Success Create Work Order',
            'data' => new WorkOrderResource($work_order)
        ]);
    }

    public function update(WorkOrder $work_order, UpdateWorkOrderRequest $request)
    {
        $data = $request->except(['work_order_items', 'assignees']);
        $items = $request->get('work_order_items', []);
        $assingees = $request->get('assignees', []);

        DB::beginTransaction();
        try {
            $work_order = $this->workorder_repo->updateWorkOrder($work_order, $data, $items);
            $this->workorder_assignee_repo->assgineeWorkOrder($work_order, $assingees);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Success Update Work Order',
            'data' => new WorkOrderResource($work_order)
        ]);
    }

    public function show(WorkOrder $work_order)
    {
        return new WorkOrderResource($work_order->load([
            'work_order_items' , 
            'priority' , 
            'task_category', 
            'user_started' , 
            'user_finished' , 
            'location', 
            'assignees.user' , 
            'work_order_logs.user_created'
        ]));
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

    public function updateItem(WorkOrder $work_order, Request $request)
    {
        $request->validate([
            'id' => ['required']
        ]);

        $data_item = $request->except(['media']);

        $wo_item = $this->workorder_item_repo->find($request->get('id'));
        if(is_null($wo_item)) {
            return response()->json([
                'message' => 'Subtask not found'
            ], 404);
        }

        $wo_item = $this->workorder_item_repo->updateItem($wo_item, $data_item, $request->file('media', null));

        return response()->json([
            'message' => 'Subtask updated successfuly',
            'data' => new WorkOrderItemResource($wo_item)
        ]);
    }


}
