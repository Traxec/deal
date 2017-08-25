<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Response;
use Validator;

class UsersController extends Controller
{

  public $successStatus = 200;

  public function create()
  {
    return view('users.create');
  }

  public function show(User $user)
  {
    // return view('users.show', compact('user'));
    return compact('user');
  }

  public function store(Request $request)
  {
    $validator = Validator::make($request->all(),[
      'phone'      => 'required|regex:/^1[34578][0-9]{9}$/',
      'password'   => 'required',
      'c_password' => 'required|same :password',
    ]);
    if ($validator->fails()) {
      return response()->json(['error'=>$validator->errors()], 401);
    }
    $data = $request->all();
    $data['password']=bcrypt($data['password']);
    $data['pid'] = 0;
    $data['path'] = 0;
    $data['status'] = 1;

    // $user = User::create($data);
    $user = User::create($data);
    dd($user);
    $success['token'] =  $user->createToken('MyApp')->accessToken;
    $success['id'] =  $user->id;
    return response()->json(['success'=>$success], $this->successStatus);

  }
}
