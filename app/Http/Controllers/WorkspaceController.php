<?php

namespace App\Http\Controllers;

use App\Models\Workspace;
use Illuminate\Http\Request;
use Exception;
use App\Models\User;


class WorkspaceController extends Controller
{
    //
     public function createWorkspace(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'leader_id' => 'required|exists:users,id',
            ]);

            $workspace = Workspace::create($validated);

            return $this->created($workspace);
        } catch (Exception $e) {
            return $this->serverError($e->getMessage());
        }
    }

    // GET /workspaces

    public function getAllWorkspace()
    {
        try {
            $workspaces = Workspace::with(['leader', 'users', 'tasks'])->get();

            return $this->success($workspaces);
        } catch (Exception $e) {
            return $this->serverError($e->getMessage());
        }
    }

    // POST /api/workspaces/{id}/users | add user to workspace
    public function addUserToWorkspace(Request $request, $id)
    {
        try {
            // find workspace
            $workspace = Workspace::find($id);

            if (!$workspace) {
                return $this->notFound('Workspace not found');
            }

            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
            ]);

            // check if user already in workspace
            $alreadyMember = $workspace->users()
                            ->where('user_id', $validated['user_id'])
                            ->exists();

            if ($alreadyMember) {
                return $this->badRequest('User already in workspace');
            }

            // add user to workspace to the tabel
            $workspace->users()->attach($validated['user_id']);

            return $this->success([
                'message' => 'User added to workspace',
                'workspace' => $workspace->load('users')
            ]);
        } catch (Exception $e) {
            return $this->serverError($e->getMessage());
        }
    }
}

