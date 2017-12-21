<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    

    public function list(Request $request)
    {	
        $user = $request->user();
        var_dump($user);exit();
        return 312312;
    }

}