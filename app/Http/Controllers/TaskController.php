<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Workspace;
use Illuminate\Http\Request;
use Exception;


class TaskController extends Controller
{
    // POST /api/tasks | create  task
    public function addTask(Request $request)
    {

        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'body' => 'nullable|string',
                'workspace_id' => 'required|exists:workspaces,id',
                'creator_id' => 'required|exists:users,id',
                'assigned_to_id' => 'nullable|exists:users,id',
                'status' => 'nullable|string|in:pending,in_progress,completed',
                'deadline' => 'nullable|date',
            ]);

            // get workspace
            $workspace = Workspace::find($validated['workspace_id']);

            //  if creator belongs to workspace
            $creatorIsMember = $workspace->users()
                ->where('user_id', $validated['creator_id'])
                ->exists();
            $creatorIsLeader = $workspace->leader_id === $validated['creator_id'];

            if (!$creatorIsMember && !$creatorIsLeader) {
                return $this->forbidden('creator is not a member of this workspace');
            }

            //  if assigned user belongs to workspace 
            if (isset($validated['assigned_to_id'])) {
                $assignedIsMember = $workspace->users()
                    ->where('user_id', $validated['assigned_to_id'])
                    ->exists();
                $assignedIsLeader = $workspace->leader_id === $validated['assigned_to_id'];

                if (!$assignedIsMember && !$assignedIsLeader) {
                    return $this->forbidden('assigned user is not a member of this workspace');
                }
            }

            // defualte status
            if (!isset($validated['status'])) {
                $validated['status'] = 'pending';
            }

            $task = Task::create($validated);

            return $this->created($task);
        } catch (Exception $e) {
            return $this->serverError($e->getMessage());
        }
    }

    // GET /tasks?workspaceId=
    public function getTask(Request $request)
    {
        try {
         
            if (!$request->has('workspaceId')) {
                return $this->badRequest('workspaceId is required');
            }

            //  if workspace exists
            $workspace = Workspace::find($request->workspaceId);
            if (!$workspace) {
                return $this->notFound('Workspace not found');
            }

            // get tasks for this workspace
            $tasks = Task::where('workspace_id', $request->workspaceId)
                ->with(['workspace', 'creator', 'assignedTo'])
                ->get();

            return $this->success($tasks);
        } catch (Exception $e) {
            return $this->serverError($e->getMessage());
        }
    }

// PATCH /tasks/{id} 
public function editTask(Request $request, $id)
{
    try {
        $task = Task::find($id);

        if (!$task) {
            return $this->notFound('Task not found');
        }

        //update the status
        $task->update(['status' => 'completed']);

        return $this->success($task);
    } catch (Exception $e) {
        return $this->serverError($e->getMessage());
    }
}
}
