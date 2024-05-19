<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HistoryPompaResource;
use App\Http\Resources\PompaResource;
use App\Models\HistoryPompa;
use App\Models\Pompa;
use App\Repositories\HistoryPompaRepository;
use Illuminate\Http\Request;

class HistoryPompaController extends Controller
{

    protected $history_pompa_repo;

    public function __construct()
    {
        $this->history_pompa_repo = app(HistoryPompaRepository::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function update(HistoryPompa $historyPompa, Request $request)
    {
        $request->validate([
            'meter_counter' => 'required',
        ]);



        $data = $this->history_pompa_repo->updateHistory($historyPompa, $request->get('meter_counter' , 0));

        return response()->json([
            'message' => 'Meter counter update successfuly',
            'data' => new HistoryPompaResource($data)
        ]);
    }

}
