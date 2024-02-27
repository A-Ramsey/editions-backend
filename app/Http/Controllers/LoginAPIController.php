<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginAPIController extends Controller
{
    public function __invoke()
    {
        $formData = request()->validate(User::rules());

        $authSuccess = Auth::attempt(['email' => $formData['email'], 'password' => $formData['password']]);
        if (!$authSuccess) {
            return response()->json([
                'success' => false,
                'message'=> "User not found"
            ]);
        }
        $user = User::where('email', $formData['email'])->get();
        $token = request()->user()->createToken('auth_token');
        return response()->json([
            'success' => true,
            'message' => 'Token generated',
            'user' => $user,
            'token' => $token,
        ]);
    }
}
