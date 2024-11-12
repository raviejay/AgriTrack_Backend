<?php

namespace App\Http\Controllers;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(UserRequest $request)
{
    $validated = $request->validated();

    // Ensure password is hashed
    $validated['password'] = Hash::make($validated['password']);

    // Create the user with validated and hashed data
    $user = User::create($validated);

    return response()->json($user, 201);
}

}
