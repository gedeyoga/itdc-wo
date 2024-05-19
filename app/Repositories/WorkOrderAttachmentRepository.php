<?php 

namespace App\Repositories;

use App\Models\Task;
use App\Models\User;

interface WorkOrderAttachmentRepository {

    public function createAttachment(array $data);

}