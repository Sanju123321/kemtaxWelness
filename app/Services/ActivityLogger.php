<?php

namespace App\Services;

use App\Models\AdminActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    public static function log(
        string $action,
        string $targetType = null,
        int    $targetId   = null,
        array  $details    = []
    ): void {
        AdminActivityLog::create([
            'admin_id'    => auth('admin')->id(),
            'action'      => $action,
            'target_type' => $targetType,
            'target_id'   => $targetId,
            'details'     => $details ?: null,
            'ip'          => request()->ip(),
        ]);
    }
}
