<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AdminActivityLog;

class ActivityLogController extends Controller
{
    public function index()
    {
        $logs = AdminActivityLog::with('admin')
            ->latest()
            ->paginate(30);

        return view('backend.activity-logs.index', compact('logs'));
    }
}
