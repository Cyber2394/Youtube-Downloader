<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SpotifyController extends Controller
{
    public function getSpotifyAccessToken()
    {
        $clientId = env('SPOTIFY_CLIENT_ID');
        $clientSecret = env('SPOTIFY_CLIENT_SECRET');

        $response = Http::asForm()->post('https://accounts.spotify.com/api/token', [
            'grant_type' => 'client_credentials',
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
        ]);

        if ($response->ok()) {
            $data = $response->json();
            return $data['access_token'];
        } else {
            return null;
        }
    }

    public function searchSongs($query)
    {
        $accessToken = $this->getSpotifyAccessToken();
        if (!$accessToken) {
            // Handle token retrieval failure
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])->get('https://api.spotify.com/v1/search', [
            'q' => $query,
            'type' => 'track',
            'limit' => 5, // Number of Songs
        ]);

        if ($response->ok()) {
            $data = $response->json();
            return $data['tracks']['items'];
        } else {
            return null;
        }
    }

    public function search(Request $request)
    {
        $query = $request->input('input');

        $songs = $this->searchSongs($query);

        return response()->json($songs);
    }
}
