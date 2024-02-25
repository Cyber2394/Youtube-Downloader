<?php

namespace App\Classes;

use Illuminate\Support\Facades\Http;
use App\Models\User;

class Identity
{

    public function getCoreAttributesTable($email)
    {
        // Use where to find a user by email
        $user = User::where('email', $email)->first();

        $combinedUserData = [];

        if (!empty($user)) {
            $combinedData = [
                "id" => $user->id,
                "name" => $user->name,
                "email" => $user->email,
                // Add other attributes as needed
            ];
            $combinedUserData[] = $combinedData;
        } else {
            $combinedData = [
                "id" => "Not Found",
                "name" => "Not Found",
                "email" => $email,
            ];
            $combinedUserData[] = $combinedData;
        }

        return $combinedUserData;
    }

    public function getAPICoreAttributesTable($userName)
    {
        $userData = Http::withoutVerifying()
            ->withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])
            ->get('https://jsonplaceholder.typicode.com/users', [
                "username" => $userName,
            ])->json();

        $combinedUserData = [];
        if (!empty($userData)) {
            foreach ($userData as $user) {
                $address = $user["address"];
                $geo = $address["geo"];
                $company = $user["company"];
                $combinedData = [
                    "id" => $user["id"],
                    "name" => $user["name"],
                    "username" => $user["username"],
                    "email" => $user["email"],
                    "phone" => $user["phone"],
                    "website" => $user["website"],
                    "street" => $address["street"],
                    "suite" => $address["suite"],
                    "city" => $address["city"],
                    "zipcode" => $address["zipcode"],
                ];
                $combinedUserData[] = $combinedData;
            }
        }

        if (empty($userData)) {
            $combinedData = [
                "id" => "Not Found",
                "name" => "Not Found",
                "username" => $userName,
                "email" => "Not Found",
                "phone" => "Not Found",
                "website" => "Not Found",
                "street" => "Not Found",
                "suite" => "Not Found",
                "city" => "Not Found",
                "zipcode" => "Not Found",
            ];
            $combinedUserData[] = $combinedData;
        }
        return $combinedUserData;
    }

    public function getAPIUserNameFromEmail($email)
    {
        $userData = Http::withoutVerifying()
            ->withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])
            ->get('https://jsonplaceholder.typicode.com/users', [
                "email" => $email,
            ])->json();


        if (!empty($userData)) {
            foreach ($userData as $user) {
                $userName = $user["username"];
            }
        } else {
            $userName = "Not Found";
        }
        return $userName;
    }

    public function getAPIUserNameFromId($id)
    {
        $userData = Http::withoutVerifying()
            ->withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])
            ->get('https://jsonplaceholder.typicode.com/users', [
                "id" => $id,
            ])->json();


        if (!empty($userData)) {
            foreach ($userData as $user) {
                $userName = $user["username"];
            }
        } else {
            $userName = "Not Found";
        }
        return $userName;
    }
}
