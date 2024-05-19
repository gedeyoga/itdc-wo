<?php 

namespace App\Repositories;

use App\Models\HistoryPompa;
use App\Models\User;

interface HistoryPompaRepository {
    public function updateHistory(HistoryPompa $historyPompa, $meter_counter);
}