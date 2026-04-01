<?php

namespace App\Http\Controllers;

use App\Http\Resources\ActivityLogResource;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function logs(){
        $logs = ActivityLog::get();

        return response()->json([
            'status' =>true,
            'message' => 'All logs are listed here',
            'data' => ActivityLogResource::collection($logs)
        ],200);
    }
}
