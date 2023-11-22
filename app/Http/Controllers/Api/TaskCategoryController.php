<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskCategoryResource;
use App\Models\TaskCategory;
use App\Repositories\TaskCategoryRepository;
use Illuminate\Http\Request;

class TaskCategoryController extends Controller
{
    protected $task_category_repo;

    public function __construct() {
        $this->task_category_repo = app(TaskCategoryRepository::class);
    }

    public function list(Request $request)
    {
        $datas = $this->task_category_repo->list($request->all());

        return TaskCategoryResource::collection($datas);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        $task_category = $this->task_category_repo->create($request->all());

        return response()->json([
            'message' => 'Berhasil menambah kategori',
            'data' => new TaskCategoryResource($task_category)
        ]);
    }

    public function update(TaskCategory $taskCategory , Request $request)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        $task_category = $this->task_category_repo->update( $taskCategory, $request->all());

        return response()->json([
            'message' => 'Berhasil menambah kategori',
            'data' => new TaskCategoryResource($task_category)
        ]);
    }

    public function destroy(TaskCategory $taskCategory)
    {

        $this->task_category_repo->destroy($taskCategory);

        return response()->json([
            'message' => 'Berhasil menghapus kategori'
        ]);
    }
}
