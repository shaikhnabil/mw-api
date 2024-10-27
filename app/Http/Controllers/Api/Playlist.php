<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\DjCharts;
use App\Models\Streambox;
use App\Models\UsersMobileToken;
use Illuminate\Http\Request;

class Playlist extends BaseController
{
    public function index(Request $request)
    {
        //$user_token = $request->query('user_token');
        $user_token = $request->input('user_token');
        $limit = $request->query('limit', 10);
        $offset = $request->query('offset', 0);

        if (!$user_token) {
            return $this->sendError('User token is required.', 400);
        }

        $userMobileToken = UsersMobileToken::where('token', $user_token)->first();

        if (!$userMobileToken) {
            return $this->sendError('Invalid token', 401);
        }

        $user_id = $userMobileToken->user_id;

        $query = Streambox::withCount([
            'followersCount as likes',
            'items as total_tracks'
        ])->where('user_id', '=', $user_id);

        $query->orderBy('tstamp', 'DESC');

        $playlists = $query->limit($limit)->offset($offset)->get();

        if ($playlists->isEmpty()) {
            return $this->sendError('No playlists found for this user', 404);
        }

        return $this->sendResponse($playlists, 'Playlists retrived successfully.', 200);
    }

    public function show(Request $request)
    {
        $user_token = $request->input('user_token');
        $playlist_id = $request->input('playlist_id');

        if (!$user_token) {
            return $this->sendError('User token is required.', 400);
        }

        $userMobileToken = UsersMobileToken::where('token', $user_token)->first();

        if (!$userMobileToken) {
            return $this->sendError('Invalid token', 401);
        }

        $user_id = $userMobileToken->user_id;

        $playlist = Streambox::withCount([
                'followersCount as likes',
                'items as total_tracks'
            ])->where('user_id', '=', $user_id)->where('id', $playlist_id)->first();

        if (!$playlist) {
            return $this->sendError('Playlist not found,', 404);
        }

        return $this->sendResponse($playlist, 'Playlist retrived successfully.', 200);
    }
}

