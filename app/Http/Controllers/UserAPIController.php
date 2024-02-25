<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\Identity;

class UserAPIController extends Controller
{
    function searchUserByUserName(Request $request)
    {
        $Identity = new Identity();
        $userName = $request->input('input');

        $userDataArray = $Identity->getAPICoreAttributesTable($userName);
        
        return response()->json($userDataArray);
    }

    function searchUserByEmail(Request $request)
    {
        $Identity = new Identity();
        $email = $request->input('input');

        $userName = $Identity->getAPIUserNameFromEmail($email);

        $userDataArray = $Identity->getAPICoreAttributesTable($userName);
        
        return response()->json($userDataArray);
    }

    function searchUserById(Request $request)
    {
        $Identity = new Identity();
        $id = $request->input('input');

        $userName = $Identity->getAPIUserNameFromId($id);

        $userDataArray = $Identity->getAPICoreAttributesTable($userName);
        
        return response()->json($userDataArray);
    }
}

