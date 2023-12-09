<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Repositories\TaskRepository;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $task_repo;

    public function __construct() {
        $this->task_repo = app(TaskRepository::class);
    }

    public function list(Request $request)
    {
        $datas = $request->all();

        $tasks = $this->task_repo->list($datas);

        return TaskResource::collection($tasks);
    }

    public function store(CreateTaskRequest $request)
    {
        $datas = $request->except('task_items');

        $task = $this->task_repo->createTask($datas, $request->get('task_items', []));

        return response()->json([
            'message' => 'Berhasil menambahkan task',
            'data' => new TaskResource($task),
        ]);
    }

    public function update(Task $task, UpdateTaskRequest $request)
    {
        $datas = $request->except('task_items');
        $items = $request->get('task_items', []);

        $task = $this->task_repo->updateTask($task, $datas, $items);

        return response()->json([
            'message' => 'Berhasil merubah task',
            'data' => new TaskResource($task),
        ]);

    }

    public function destroy(Task $task)
    {
        $this->task_repo->destroy($task);

        return response()->json([
            'message' => 'Berhasil menghapus task'
        ]);
    }

    public function show(Task $task)
    {
        $task->load(['priority',  'task_category', 'task_items']);
        return new TaskResource($task);
    }
}
