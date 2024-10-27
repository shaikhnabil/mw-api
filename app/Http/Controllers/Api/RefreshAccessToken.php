<?php

// namespace App\Http\Controllers\Api;

// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
// use App\Models\User;
// use Illuminate\Support\Str;
// use Illuminate\Support\Facades\DB;
// use Carbon\Carbon;

// class RefreshAccessToken extends Controller
// {
//     public function refreshAccessToken(Request $request)
//     {
//         $currentToken = $request->bearerToken();

//         // $currentToken = $request->input('token');

//         if (!$currentToken) {
//             return response()->json(['error' => 'No access token provided'], 401);
//         }

//         $hashedToken = hash('sha256', $currentToken);

//         $tokenData = DB::table('personal_access_tokens')
//             ->where('token', $hashedToken)
//             ->first();

//         if (!$tokenData) {
//             return response()->json(['error' => 'Invalid current token'], 404);
//         }

//         if (Carbon::now()->greaterThan(Carbon::parse($tokenData->expires_at))) {

//             $user = User::find($tokenData->tokenable_id);

//             // check any other active tokens for this user
//             $activeTokens = DB::table('personal_access_tokens')
//                 ->where('tokenable_type', 'App\Models\User')
//                 ->where('tokenable_id', $user->id)
//                 ->where(function ($query) {
//                     $query->whereNull('expires_at')->orWhere('expires_at', '>', Carbon::now());
//                 })->count();

//             if ($activeTokens > 0) {
//                 return response()->json([
//                     'message' => 'An active token already exists for this user. Please use the active token.',
//                 ], 200);
//             }

//             $newToken = $user->createToken($user->id . '-Token-' . Carbon::now(), ['*'], now()->addHour())->plainTextToken;
//             $expiresAt = Carbon::now()->addHour();

//             // DB::table('personal_access_tokens')
//             //     ->where('id', $tokenData->id)
//             //     ->update([
//             //         'token' => hash('sha256', $newToken),
//             //         'expires_at' => $expiresAt,
//             //         'updated_at' => now(),
//             //     ]);


//             return response()->json([
//                 'message' => 'New Token generated successfully',
//                 'token_type' => 'bearer',
//                 'new_token' => $newToken,
//                 'expires_at' => $expiresAt,
//             ], 201);
//         }


//         return response()->json([
//             'message' => 'Current token is still valid',
//             'token_type' => 'bearer',
//             'current_token' => $currentToken,
//             'expires_at' => $tokenData->expires_at,
//         ], 200);
//     }
// }

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SecretKeys;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RefreshAccessToken extends Controller
{
    public function refreshAccessToken(Request $request)
    {
        $currentToken = $request->bearerToken();

        if (!$currentToken) {
            return response()->json(['error' => 'No access token provided'], 401);
        }

        $hashedToken = hash('sha256', $currentToken);

        $tokenData = DB::table('personal_access_tokens')
            ->where('token', $hashedToken)
            ->first();

        if (!$tokenData) {
            return response()->json(['error' => 'Invalid current token'], 404);
        }

        // Check if the token has expired
        if (Carbon::now()->lessThan(Carbon::parse($tokenData->expires_at))) {
            return response()->json([
                'message' => 'Current token is still valid',
                'token_type' => 'bearer',
                'current_token' => $currentToken,
                'expires_at' => $tokenData->expires_at,
            ], 200);
        }

        // Fetch the SecretKey associated with the token
        $secretKey = SecretKeys::find($tokenData->tokenable_id);

        // Delete the expired token
      //  DB::table('personal_access_tokens')->where('id', $tokenData->id)->delete();

        // Generate a new token
        $newToken = $secretKey->createToken('API-Access-Token', ['*'], now()->addHour())->plainTextToken;
        $expiresAt = Carbon::now()->addHour();

        return response()->json([
            'message' => 'New Token generated successfully',
            'token_type' => 'bearer',
            'new_token' => $newToken,
            'expires_at' => $expiresAt,
        ], 201);
    }
}
