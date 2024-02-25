<?php
namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        // Get the user message from the request
        $message = $request->input('input');

        // Get the conversation ID and history from the request
        $conversationId = $request->input('conversationId');
        $conversationHistory = $request->input('conversationHistory');

        // Prepare the API request payload
        $payload = [
            'messages' => array_merge($conversationHistory, [
                [
                    'role' => 'user',
                    'content' => $message,
                ],
            ]),
            'model' => 'gpt-3.5-turbo', // Specify the model you want to use
            'temperature' => 0.8, // Adjust the temperature value as desired
            'max_tokens' => 200, // Adjust the max tokens value as desired
        ];

        // Create a Guzzle client instance
        $client = new Client();

        // Make the API request to ChatGPT
        $response = $client->post('https://api.openai.com/v1/chat/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                'Content-Type' => 'application/json',
            ],
            'json' => $payload,
        ]);

        // Extract the model response from the API response
        $result = json_decode($response->getBody(), true);
        $modelResponse = $result['choices'][0]['message']['content'];

        // Return the model response along with the updated conversation history
        return response()->json([
            'message' => $modelResponse,
            'user' => $message,
            'conversationHistory' => $payload['messages'], // Send back the updated conversation history
        ]);
    }
}