<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTaskScheduleRequest;
use App\Http\Requests\UpdateTaskScheduleRequest;
use App\Http\Resources\TaskScheduleResource;
use App\Models\TaskSchedule;
use App\Repositories\TaskScheduleRepository;
use Illuminate\Http\Request;

class TaskScheduleController extends Controller
{

    protected $task_schedule_repo; 

    public function __construct() {
        $this->task_schedule_repo = app(TaskScheduleRepository::class);
    }

    public function list(Request $request)
    {

        $list = $this->task_schedule_repo->list($request->all());

        return TaskScheduleResource::collection($list);

    }

    public function store(CreateTaskScheduleRequest $request)
    {
        $data = $request->except('items');

        $data['user_id'] = array_map(function ($item) {
            return ['user_id' => $item];
        }, $request->get('user_id', []));

        $schedule = $this->task_schedule_repo->createSchedule($data , $request->get('items' , []));

        return response()->json([
            'message' => 'Create schedule succesfuly'
        ]);
    }

    public function update(TaskSchedule $taskSchedule , UpdateTaskScheduleRequest $request)
    {
        $data = $request->except('items');

        $data['user_id'] = array_map(function ($item) {
            return ['user_id' => $item];
        },
            $request->get('user_id', [])
        );

        $schedule = $this->task_schedule_repo->updateSchedule( $taskSchedule , $data , $request->get('items' , []));

        return response()->json([
            'message' => 'Update schedule succesfuly'
        ]);
    }

    public function destroy(TaskSchedule $taskSchedule)
    {
        $this->task_schedule_repo->destroy($taskSchedule);

        return response()->json([
            'message' => 'Delete schedule succesfuly'
        ]);
    }

    public function show(TaskSchedule $taskSchedule)
    {
        $taskSchedule->load(['created_user' , 'updated_user' , 'days' , 'months' , 'years']);
        return new TaskScheduleResource($taskSchedule);
    }
}
 