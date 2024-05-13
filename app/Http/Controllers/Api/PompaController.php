<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PompaResource;
use App\Models\Pompa;
use App\Repositories\PompaRepository;
use Illuminate\Http\Request;

class PompaController extends Controller
{

    protected $pompa_repo;

    public function __construct()
    {
        $this->pompa_repo = app(PompaRepository::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $pompas = $this->pompa_repo->list($request->all());

        return PompaResource::collection($pompas);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'year' => 'required|string',
            'type' => 'required|string',
            'power_kwh' => 'required',
            'capacity' => 'required',
            'status' => 'required|string'
        ]);

        $pompa = $this->pompa_repo->create($request->all());

        return response()->json([
            'message' => 'Success add pompa',
            'data' => new PompaResource($pompa)
        ]);
    }

    public function update(Pompa $pompa, Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'year' => 'required|string',
            'type' => 'required|string',
            'power_kwh' => 'required',
            'capacity' => 'required',
            'status' => 'required|string'
        ]);

        $pompa = $this->pompa_repo->update($pompa, $request->all());

        return response()->json([
            'message' => 'Pompa update successfuly',
            'data' => new PompaResource($pompa)
        ]);
    }

    public function show(Pompa $pompa)
    {
        return new PompaResource($pompa);
    }

    public function destroy(Pompa $pompa)
    {

        $this->pompa_repo->destroy($pompa);

        return response()->json([
            'message' => 'Pompa delete successfuly'
        ]);
    }
}
