<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Client as GoogleClient;
use Google\Service\YouTube;
use Illuminate\Support\Facades\Artisan;


class YoutubeController extends Controller
{
    public function showDownloadForm()
    {
        return view('youtube_download');
    }

    public function showSearchForm()
    {
        return view('youtube_search');
    }

    public function DownloadYoutube(Request $request)
    {
        $url = $request->input('input');

        $fullUrl = "https://www.youtube.com/watch?v=" . $url;

        Artisan::call('app:youtube-download-command', ['url' => $url]);

        $output = Artisan::output();

        return response()->json(['message' => 'Succesful', 'output' => $output]);
    }

    public function DownloadYoutubeAll(Request $request)
    {
        $allIds = $request->input('allIds');
        $ids = explode(',', $allIds);

        $outputs = [];

        foreach ($ids as $id) {
            // Create full URL for each ID
            $fullUrl = "https://www.youtube.com/watch?v=" . $id;

            // Make Artisan call for each full URL
            Artisan::call('app:youtube-download-command', ['url' => $fullUrl]);

            // Get the output of the Artisan call
            $output = Artisan::output();

            // Store the output for each ID
            $outputs[$id] = ['message' => 'Successful', 'output' => $output];
        }

        return response()->json(['results' => $outputs]);
    }

    public function searchVideos(Request $request)
    {
        $searchQuery = $request->input('input');

        $items = explode(',', $searchQuery);

        $client = new GoogleClient();
        $client->setDeveloperKey(env('YOUTUBE_API_KEY'));

        $youtube = new YouTube($client);

        $allResults = [];

        foreach ($items as $item) {
            $searchResponse = $youtube->search->listSearch('id,snippet', [
                'q' => $item,
                'maxResults' => 1,
            ]);

            $videoId = [];
            $videoName = [];

            foreach ($searchResponse->getItems() as $searchResult) {
                $videoId[] = $searchResult->id->videoId;
                $videoName[] = $searchResult->snippet->title;
            }

            // Append the results to the $allResults array
            $allResults[] = [
                'item' => $item,
                'videoId' => $videoId,
                'videoName' => $videoName,
            ];
        }

        return response()->json($allResults);
    }

    public function searchVideosWorking1callatatime(Request $request)
    {
        $searchQuery = $request->input('input');

        // return response()->json($searchQuery);

        $client = new GoogleClient();
        $client->setDeveloperKey(env('YOUTUBE_API_KEY'));

        $youtube = new YouTube($client);

        $searchResponse = $youtube->search->listSearch('id,snippet', [
            'q' => $searchQuery,
            'maxResults' => 1,
        ]);

        $videoId = [];
        $videoName = [];

        foreach ($searchResponse->getItems() as $searchResult) {
            $videoId[] = $searchResult->id->videoId;
            $videoName[] = $searchResult->snippet->title;
        }

        return response()->json(['videoId' => $videoId, 'videoName' => $videoName]);
    }
}
