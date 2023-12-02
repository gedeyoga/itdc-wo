<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LocationResource;
use App\Models\Location;
use App\Repositories\LocationRepository;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    protected $location_repo;

    public function __construct() {
        $this->location_repo = app(LocationRepository::class);
    }

    public function list(Request $request)
    {
        $locations = $this->location_repo->list($request->all());
        return LocationResource::collection($locations);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        $location = $this->location_repo->create($request->all());

        return response()->json([
            'message' => 'Success add location',
            'data' => new LocationResource($location)
        ]);
    }

    public function update(Location $location, Request $request)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        $location = $this->location_repo->update($location, $request->all());

        return response()->json([
            'message' => 'Location update successfuly',
            'data' => new LocationResource($location)
        ]);
    }

    public function destroy(Location $location)
    {

        $this->location_repo->destroy($location);

        return response()->json([
            'message' => 'Berhasil menghapus location'
        ]);
    }
}
