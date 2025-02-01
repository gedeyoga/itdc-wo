<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LocationInstallationResource;
use App\Models\LocationInstallation;
use App\Repositories\LocationInstallationRepository;
use Illuminate\Http\Request;

class LocationInstallationController extends Controller
{

    protected $location_installation_repo;

    public function __construct()
    {
        $this->location_installation_repo = app(LocationInstallationRepository::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $data = $request->all();
        $data['relations'] = 'pompa,location';

        $location_installations = $this->location_installation_repo->list($data);

        return LocationInstallationResource::collection($location_installations);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'location_id' => 'required',
            'pompa_id' => 'required',
            'jenis_pompa' => 'required|string',
            'status' => 'required|string',
        ]);

        $location_installation = $this->location_installation_repo->create($request->all());

        return response()->json([
            'message' => 'Success add location installation',
            'data' => new LocationInstallationResource($location_installation)
        ]);
    }

    public function update(LocationInstallation $location_installation, Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'location_id' => 'required',
            'pompa_id' => 'required',
            'jenis_pompa' => 'required|string',
            'status' => 'required|string',
        ]);

        $location_installation = $this->location_installation_repo->update($location_installation, $request->all());

        return response()->json([
            'message' => 'Location installation update successfuly',
            'data' => new LocationInstallationResource($location_installation)
        ]);
    }

    public function show(LocationInstallation $location_installation)
    {

        return new LocationInstallationResource($location_installation->load(['pompa', 'location']));
    }

    public function destroy(LocationInstallation $location_installation)
    {

        $this->location_installation_repo->destroy($location_installation);

        return response()->json([
            'message' => 'Location installation delete successfuly'
        ]);
    }

    public function reportLocationInstallation(Request $request)
    {
        $params = $request->all();
        $params['relations'] = 'pompa,location';
        $datas = $this->location_installation_repo->historyPompaList($params);
        
        return LocationInstallationResource::collection($datas);
    }
}
