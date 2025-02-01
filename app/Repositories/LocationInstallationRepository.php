<?php 

namespace App\Repositories;

interface LocationInstallationRepository {

    public function list(array $params);

    public function historyPompaList(array $params);

}