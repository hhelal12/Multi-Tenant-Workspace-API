<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Workspace;
use App\Models\Task;
use Exception;

class SummaryController extends Controller
{
    // GET /api/summary | get system summary
    public function getSummary()
    {
        try {
            $summary = [
                'total_users' => User::count(),
                'total_workspaces' => Workspace::count(),
                'total_tasks' => Task::count(),
                'completed_tasks' => Task::where('status', 'completed')->count(),
                'pending_tasks' => Task::where('status', 'pending')->count(),
            ];

            return $this->success($summary);
        } catch (Exception $e) {
            return $this->serverError($e->getMessage());
        }
    }
}