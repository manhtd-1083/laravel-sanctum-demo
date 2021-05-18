<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class SanctumApiController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = auth()->user();

            return response()->json([
                'status_code' => 200,
                'tokens' => $user->tokens,
            ], 200);
        } catch (Exception $e) {
            report($e);

            return response()->json([
                'status_code' => 400,
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    public function create(Request $request)
    {
        try {
            $request->validate([
                'email' => 'email|required',
                'password' => 'required|string',
                'token_name' => 'required|string',
            ]);

            $credentials = request(['email', 'password']);

            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'status_code' => 403,
                    'message' => 'Unauthorized'
                ], 403);
            }

            $user = User::where('email', $request->email)->first();

            $abilities = ['*'];
            if ($request->has('abilities')) {
                $abilities = $request->abilities;
            }

            $token = $user->createToken($request->token_name, $abilities);

            return response()->json([
                'status_code' => 201,
                'name' => $request->token_name,
                'token' => $token->plainTextToken,
            ], 201);
        } catch (Exception $e) {
            report($e);

            return response()->json([
                'status_code' => 400,
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    public function revoke(Request $request, $tokenId)
    {
        try {
            $user = auth()->user();
            $user->tokens()->where('id', $tokenId)->delete();

            return response()->json([
                'status_code' => 200,
                'message' => 'Revoke token',
            ], 200);
        } catch (Exception $e) {
            report($e);

            return response()->json([
                'status_code' => 400,
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    public function revokeAll(Request $request)
    {
        try {
            $user = auth()->user();
            $user->tokens()->delete();

            return response()->json([
                'status_code' => 200,
                'message' => 'Revoke all tokens',
            ], 200);
        } catch (Exception $e) {
            report($e);

            return response()->json([
                'status_code' => 400,
                'error' => $e->getMessage(),
            ], 400);
        }
    }
}
