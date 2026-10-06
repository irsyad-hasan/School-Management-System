<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    public static function record(
        string $action,
        string $description,
        ?Model $subject = null,
        ?int $userId = null,
    ): ?ActivityLog {
        $actorId = $userId ?? Auth::id();

        return ActivityLog::create([
            'user_id' => $actorId,
            'action' => $action,
            'description' => $description,
            'subject_type' => $subject ? $subject::class : null,
            'subject_id' => $subject?->getKey(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
