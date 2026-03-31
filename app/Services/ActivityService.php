<?php

namespace App\Services;

use App\Models\ActivityLog;

class ActivityService
{
    public static function log(
        int $boardId,
        string $action,
        string $subjectModel,
        int $subjectId,
        array $meta = [],
        ?int $taskId = null,
    ): void {
        ActivityLog::create([
            'board_id' => $boardId,
            'user_id' => auth('sanctum')->id(),
            'action' => $action,
            'subject_model' => $subjectModel,
            'subject_id' => $subjectId,
            'meta' => $meta,
            'task_id' => $taskId,
        ]);
    }
}
