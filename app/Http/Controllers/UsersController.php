<?php

namespace App\Http\Controllers;

use App\Models\User;      
use Illuminate\Http\Request;
use Exception;    

class UsersController extends Controller
{
    // GET /api/users | return users
    public function returnUsers()
    {
        try {
            $users = User::all();
            return $this->success($users);
        } catch (Exception $e) {
            return $this->serverError($e->getMessage());
        }
    }

    // POST /api/users | create user
    public function addUser(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:8',
                'role' => 'required|string',
            ]);

            $user = User::create($validated);

            return $this->created($user);
        } catch (Exception $e) {
            return $this->serverError($e->getMessage());
        }
    }
}
