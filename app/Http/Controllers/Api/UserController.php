<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Response;

class UserController extends Controller
{
    public function __construct()
    {
        $this->content = array();
    }
    public function login()
    {
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')]))
        {
            $user = Auth::user();
            $this->content['token'] =  $user->createToken('Pizza App')->accessToken;
            $status = 200;
        } else {
            $this->content['error'] = "未授权";
             $status = 401;
        }
         return response()->json($this->content, $status);
    }
    public function details()
    {
        return response()->json(['user' => Auth::user()]);
    }
}
