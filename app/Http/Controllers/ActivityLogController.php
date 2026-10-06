<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    public function index(): View
    {
        $activityLogs = ActivityLog::with('user')
            ->latest('created_at')
            ->get();

        return view('activity-logs.index', compact('activityLogs'));
    }
}
