<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login()
    {

      $credentials = request()->only('username', 'password');
      //if returns false send error message
      if(!$token = auth()->attempt($credentials)) {
        return response()->json(['error' => 'Invalid credentials'], 401);
      }

      return response()->json(['token' => $token]);
    }
}
