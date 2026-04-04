<?php

namespace App\Http\Controllers;

use App\Http\Resources\ActivityLogResource;
use App\Models\ActivityLog;
use App\Models\Board;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function logs(Board $board)
    {
        $this->authorize('viewLog', $board);
        $logs = ActivityLog::where('board_id', $board->id)->get();
        return response()->json([
            'status' => true,
            'message' => 'All logs are listed here',
            'data' => ActivityLogResource::collection($logs)
        ], 200);
    }
}
