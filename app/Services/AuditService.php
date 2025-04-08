<?php 

namespace App\Services;

use App\Models\QueryLog;

class AuditService {

    public function saveQueryLog($action,$resorce_type,$resourceId){
        // Registrar la consulta
        QueryLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'resource_type' => $resorce_type,
            'resource_id' => $resourceId,
        ]);
    }
}