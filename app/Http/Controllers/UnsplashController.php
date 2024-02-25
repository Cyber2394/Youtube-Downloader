<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UnsplashController extends Controller
{
    public function searchImages(Request $request)
    {
        $query = $request->input('input');

        // Get the Unsplash API key from the configuration
        $accessKey = env('UNSPLASH_ACCESS_KEY');

        // Make a request to the Unsplash API to fetch images based on the search query
        $response = Http::get("https://api.unsplash.com/photos/random", [
            'client_id' => $accessKey,
            'count' => 1,
            'query' => $query,
        ]);

        $data = $response->json();

        return response()->json(['image' => $data[0]]);
    }
}
