<?php 

namespace App\Repositories;

use App\Models\HistoryPompa;
use App\Models\User;

interface HistoryPompaRepository {
    public function updateHistory(HistoryPompa $historyPompa, $meter_counter);
    public function historyPompaByLocations($location_installation_id, array $params = []);

}