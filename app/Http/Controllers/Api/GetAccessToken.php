<?php

// namespace App\Http\Controllers\Api;

// use App\Http\Controllers\Controller;
// use App\Models\SecretKeys;
// use App\Models\User;
// use Illuminate\Http\Request;
// use Carbon\Carbon;
// use Illuminate\Support\Facades\DB;

// class GetAccessToken extends Controller
// {
//     public function getToken(Request $request)
//     {
//         $validated = $request->validate([
//             'secret_key' => 'required',
//         ]);

//         $secretKey = SecretKeys::where('secret_key', $validated['secret_key'])->first();

//         if (!$secretKey) {
//             return response()->json(['error' => 'Invalid secret key'], 404);
//         }

//         $user = User::find($secretKey->user_id);

//         $existingToken = DB::table('personal_access_tokens')
//             ->where('tokenable_type', 'App\Models\User')
//             ->where('tokenable_id', $user->id)
//             ->where(function ($query) {
//                 $query->whereNull('expires_at')->orWhere('expires_at', '>', Carbon::now());
//             })->first();

//         if ($existingToken) {
//             return response()->json([
//                 'message' => 'You already generated token refresh it if expired',
//                 'token_type' => 'bearer',
//                 'expires_at' => $existingToken->expires_at,
//             ], 200);
//         }


//         $token = $user->createToken($user->id . '-Token-' . Carbon::now(), ['*'], now()->addHour())->plainTextToken;

//         $expiresAt = Carbon::now()->addHour();

//         return response()->json([
//             'message' => 'Token Created successfully',
//             'token_type' => 'bearer',
//             'token' => $token,
//             'expires_at' => $expiresAt,
//         ], 201);
//     }
// }

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SecretKeys;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GetAccessToken extends Controller
{
    public function getToken(Request $request)
    {
        $validated = $request->validate([
            'secret_key' => 'required',
        ]);

        // Check if the secret key is valid
        $secretKey = SecretKeys::where('secret_key', $validated['secret_key'])->first();

        if (!$secretKey) {
            return response()->json(['error' => 'Invalid secret key'], 404);
        }

        // Check for existing active token
        $existingToken = DB::table('personal_access_tokens')
            ->where('tokenable_type', 'App\Models\SecretKeys')
            ->where('tokenable_id', $secretKey->id)
            ->where(function ($query) {
                $query->whereNull('expires_at')->orWhere('expires_at', '>', Carbon::now());
            })
            ->first();

        if ($existingToken) {
            return response()->json([
                'message' => 'Token already generated. Refresh if expired.',
                'token_type' => 'bearer',
                'expires_at' => $existingToken->expires_at,
            ], 200);
        }

        // Generate a new token valid for 1 hour
        $token = $secretKey->createToken('API-Access-Token', ['*'], Carbon::now()->addHour())->plainTextToken;
        $expiresAt = Carbon::now()->addHour();

        return response()->json([
            'message' => 'Token created successfully',
            'token_type' => 'bearer',
            'token' => $token,
            'expires_at' => $expiresAt,
        ], 201);
    }
}
