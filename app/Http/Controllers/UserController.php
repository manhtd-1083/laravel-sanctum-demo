<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        if (!auth()->user()->tokenCan('user:view')) {
            return response()->json([
                'status_code' => 403,
                'message' => 'Unauthorized'
            ], 403);
        }

        return response()->json([
            'users' => User::all(),
        ], 200);
    }

    public function show()
    {
        if (!auth()->user()->tokenCan('user:view')) {
            return response()->json([
                'status_code' => 403,
                'message' => 'Unauthorized'
            ], 403);
        }

        return response()->json([
            'user' => auth()->user(),
        ], 200);
    }

    public function destroy()
    {
        if (!auth()->user()->tokenCan('user:destroy')) {
            return response()->json([
                'status_code' => 403,
                'message' => 'Unauthorized'
            ], 403);
        }

        auth()->user()->delete();

        return response()->json([
            'status_code' => 200,
            'message' => 'Account Deleted'
        ], 200);
    }
}
