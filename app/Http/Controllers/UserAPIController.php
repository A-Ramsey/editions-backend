<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $formData = $request->validate(User::rules(create: true));
        $formData['password'] = Hash::make($formData['password']);
        $user = User::create($formData);
        return response()->json(['user' => $user]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user = User::where('id', $user->id)
                    ->with('posts')
                    ->with('comments')
                    ->with('images')
                    ->with('postReactions')
                    ->get();
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $formData = $request->validate(User::rules());
        $user = Auth::user();
        $userId = User::where('id', $user->id)->update($formData);
        $user->refresh();
        return response()->json(['user' => $user]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
