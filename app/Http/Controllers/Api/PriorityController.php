<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PriorityResource;
use App\Models\Priority;
use App\Repositories\PriorityRepository;
use Illuminate\Http\Request;

class PriorityController extends Controller
{
    protected $priority_repo;

    public function __construct() {
        $this->priority_repo = app(PriorityRepository::class);
    }

    public function list(Request $request)
    {
        $datas = $this->priority_repo->list($request->all());

        return PriorityResource::collection($datas);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        $priority = $this->priority_repo->create($request->all());

        return response()->json([
            'message' => 'Berhasil menambah priority',
            'data' => new PriorityResource($priority)
        ]);
    }

    public function update(Priority $priority , Request $request)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        $priority = $this->priority_repo->update( $priority, $request->all());

        return response()->json([
            'message' => 'Berhasil menambah priority',
            'data' => new PriorityResource($priority)
        ]);
    }

    public function destroy(Priority $priority)
    {

        $this->priority_repo->destroy($priority);

        return response()->json([
            'message' => 'Berhasil menghapus priority'
        ]);
    }
}
