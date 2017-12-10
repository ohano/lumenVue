<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
	public function login(Request $request)
	{
		var_dump($request->input('username'));
		
	}
}