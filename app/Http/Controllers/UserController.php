<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\Identity;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function deleteAccount(Request $request)
    {
        $Identity = new Identity();

        $email = $request->input('input');
        User::where('email', $email)->delete();

        $userDataArray = $Identity->getCoreAttributesTable($email);
        return response()->json($userDataArray);
    }

    public function searchUserByEmail(Request $request)
    {
        $Identity = new Identity();

        $email = $request->input('input');

        $userDataArray = $Identity->getCoreAttributesTable($email);
        return response()->json($userDataArray);
    }

    public function searchUserById(Request $request)
    {
        $Identity = new Identity();

        $id = $request->input('input');

        $user = User::find($id);

        if (empty($user)) {
            $email = "Not Found";
        } else {
            $email = $user->email;
        }
        $userDataArray = $Identity->getCoreAttributesTable($email);
        return response()->json($userDataArray);
    }

    public function generateFakeUser(Request $request)
    {
        $Identity = new Identity();

        $faker = Faker::create();

        $fakeUser = DB::table('users')->insertGetId([
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'password' => bcrypt('password'),
        ]);

        // Retrieve the email from the inserted user
        $email = DB::table('users')->where('id', $fakeUser)->value('email');

        $userDataArray = $Identity->getCoreAttributesTable($email);
        return response()->json($userDataArray);
    }

    public function CreateUser1(Request $request)
    {
        $Identity = new Identity();

        $faker = Faker::create();

        $input = $request->input('input');

        $inputArray = explode(',', $input);

        $User = DB::table('users')->insertGetId([
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'password' => bcrypt('password'),
        ]);

        // Retrieve the email from the inserted user
        $email = DB::table('users')->where('id', $User)->value('email');

        $userDataArray = $Identity->getCoreAttributesTable($email);
        return response()->json($userDataArray);
    }

    public function CreateUser(Request $request)
    {
        $Identity = new Identity();

        $input = $request->input('input');

        // Separate $input by commas
        $inputArray = explode(',', $input);

        foreach ($inputArray as $item) {
            // Split each part of $input by another delimiter if needed
            $userData = explode(':', $item);
            
            // Extract values or use default values if not provided
            $name = $userData[0] ?? 'DefaultName';
            $email = $userData[1] ?? 'default@example.com';
            $password = $userData[2] ?? 'password';

            // Insert fake user
            $fakeUser = DB::table('users')->insertGetId([
                'name' => $name,
                'email' => $email,
                'password' => bcrypt($password),
            ]);

            // Retrieve the email from the inserted user
            $email = DB::table('users')->where('id', $fakeUser)->value('email');

            $userDataArray = $Identity->getCoreAttributesTable($email);
        }
        return response()->json($userDataArray);
    }
}
