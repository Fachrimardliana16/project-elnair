<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

/**
 * ActivityLogger
 *
 * Central forensic audit-trail service.  Call this from any controller or
 * observer whenever data is mutated so that every important state change is
 * persisted to the `activity_logs` table AND written to the dedicated
 * 'activity' log channel.
 *
 * Usage:
 *   ActivityLogger::log($model, 'updated', $before, $after);
 *   ActivityLogger::log(null, 'lead_submitted', null, ['name' => ..., 'phone' => ...]);
 */
class ActivityLogger
{
    /**
     * Record an activity event.
     *
     * @param  Model|null  $subject   The Eloquent model that was mutated (or null for generic events)
     * @param  string      $action    Short snake_case verb: created|updated|deleted|status_changed|lead_submitted
     * @param  array|null  $before    The model state BEFORE the mutation (use $model->getOriginal())
     * @param  array|null  $after     The model state AFTER the mutation (use $model->getAttributes())
     */
    public static function log(
        ?Model $subject,
        string $action,
        ?array $before = null,
        ?array $after  = null
    ): void {
        try {
            $ipAddress = Request::ip();
            $userAgent = Request::userAgent();
            $userId    = Auth::id();

            // Strip sensitive fields before persisting
            $sensitiveKeys = ['password', 'remember_token', 'fb_capi_token', 'tiktok_capi_token'];
            if ($before) {
                $before = array_diff_key($before, array_flip($sensitiveKeys));
            }
            if ($after) {
                $after = array_diff_key($after, array_flip($sensitiveKeys));
            }

            ActivityLog::create([
                'user_id'      => $userId,
                'subject_type' => $subject ? get_class($subject) : null,
                'subject_id'   => $subject?->getKey(),
                'action'       => $action,
                'before'       => $before,
                'after'        => $after,
                'ip_address'   => $ipAddress,
                'user_agent'   => $userAgent,
            ]);

            // Mirror to dedicated activity log channel (separate from laravel.log)
            Log::channel('activity')->info("[{$action}]", [
                'subject'    => $subject ? (get_class($subject) . '#' . $subject->getKey()) : 'generic',
                'user_id'    => $userId,
                'ip_address' => $ipAddress,
            ]);
        } catch (\Throwable $e) {
            // Never let logging failure break the primary request flow
            Log::error('ActivityLogger failed: ' . $e->getMessage());
        }
    }
}
