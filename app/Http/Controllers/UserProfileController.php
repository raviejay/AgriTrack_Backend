<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; // For logging

class UserProfileController extends Controller
{
    /**
     * Show the user profile data.
     */
    public function show()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Check if user is authenticated
        if (!$user) {
            return response()->json(['error' => 'User not authenticated.'], 401);
        }
        
        // Eager load the user's profile
        $user->load('profile'); // Ensure the profile is loaded

        // If the user doesn't have a profile, return an error
        if (!$user->profile) {
            return response()->json(['error' => 'Profile not found for this user.']);
        }

        // Retrieve profile details
        $profile = $user->profile;

        // Return user and profile data
        return response()->json([
            'user' => [
                'email' => $user->email,
                'phone_number' => $profile->phone_number,
                'address' => $profile->address,
                'profile_picture' => $profile->profile_picture ? asset('storage/' . $profile->profile_picture) : null,
            ],
        ]);
    }

    /**
     * Store or update the user profile.
     */
    public function storeOrUpdate(Request $request)
    {
        // Validate the input
        $request->validate([
            'phone_number' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Get the authenticated user
        $user = Auth::user();

        // Check if the user already has a profile
        $profile = $user->profile;

        // If not, create a new profile
        if (!$profile) {
            $profile = new UserProfile();
            $profile->user_id = $user->id;
        }

        // Update profile fields
        $profile->phone_number = $request->input('phone_number');
        $profile->address = $request->input('address');

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists
            if ($profile->profile_picture && Storage::exists($profile->profile_picture)) {
                Storage::delete($profile->profile_picture);
            }

            // Store new profile picture and get the path
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            Log::info("Profile picture stored at: " . $path); // Debugging log
            $profile->profile_picture = $path;
        }

        // Save the profile
        $profile->save();

        // Return response
        return response()->json([
            'message' => 'Profile updated successfully.',
            'profile' => [
                'phone_number' => $profile->phone_number,
                'address' => $profile->address,
                'profile_picture' => $profile->profile_picture ? asset('storage/' . $profile->profile_picture) : null,
            ],
        ]);
    }
}
