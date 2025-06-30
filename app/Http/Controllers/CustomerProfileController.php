<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class CustomerProfileController extends Controller
{
    /**
     * Display the customer's profile page.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    /**
     * Update the customer's profile information.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validation rules with custom messages for Sri Lankan users
        $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20', 'regex:/^(?:\+94|0)[1-9][0-9]{8}$/'],
            'address' => ['nullable', 'string', 'max:255'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'current_password' => ['nullable', 'required_with:password', 'current_password'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ], [
            'name.string' => 'Your name should only contain letters and spaces.',
            'name.max' => 'Your name is too long. Please use up to 255 characters.',
            'email.email' => 'Please enter a valid email address (e.g., example@gmail.com).',
            'email.max' => 'Your email address is too long. Please use up to 255 characters.',
            'email.unique' => 'This email is already used by another account.',
            'phone.max' => 'Your phone number is too long. Please use up to 20 characters.',
            'phone.regex' => 'Please enter a valid Sri Lankan phone number (e.g., +94761234567 or 0761234567).',
            'address.max' => 'Your address is too long. Please use up to 255 characters.',
            'profile_photo.image' => 'Please upload a valid image file (JPEG, PNG, JPG, or GIF).',
            'profile_photo.mimes' => 'Please upload an image in JPEG, PNG, JPG, or GIF format.',
            'profile_photo.max' => 'The image file is too large. Please use a file smaller than 2MB.',
            'current_password.required_with' => 'Please enter your current password to change your password.',
            'current_password.current_password' => 'The current password you entered is incorrect.',
            'password.min' => 'Your new password must be at least 8 characters long.',
            'password.confirmed' => 'The new password and confirmation do not match.',
        ]);

        try {
            // Prepare data for update
            $data = [];

            // Only update fields that are provided
            if ($request->filled('name')) {
                $data['name'] = $request->name;
            }
            if ($request->filled('email')) {
                $data['email'] = $request->email;
            }
            if ($request->filled('phone')) {
                $data['phone'] = $request->phone;
            }
            if ($request->filled('address')) {
                $data['address'] = $request->address;
            }

            // Handle profile photo upload
            if ($request->hasFile('profile_photo')) {
                // Delete old photo if it exists
                if ($user->profile_photo) {
                    Storage::disk('public')->delete($user->profile_photo);
                }

                // Store new photo
                $path = $request->file('profile_photo')->store('profile_photos', 'public');
                $data['profile_photo'] = $path;
            }

            // Update password if provided
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            // Only update if there are changes
            if (!empty($data)) {
                $user->update($data);
                return redirect()->back()->with('success', 'Profile updated successfully!');
            }

            return redirect()->back()->with('error', 'No changes were made to your profile.');
        } catch (\Exception $e) {
            Log::error('Customer profile update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Sorry, we couldn’t update your profile. Please try again.');
        }
    }

    /**
     * Delete the customer's account.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $user = Auth::user();

        // Validate current password
        $request->validate([
            'current_password' => ['required', 'current_password'],
        ], [
            'current_password.required' => 'Please enter your current password to delete your account.',
            'current_password.current_password' => 'The password you entered is incorrect.',
        ]);

        try {
            // Delete profile photo if it exists
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            // Log out the user
            Auth::logout();

            // Delete the user
            $user->delete();

            // Invalidate session
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/')->with('success', 'Your account has been deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Customer account deletion failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Sorry, we couldn’t delete your account. Please try again.');
        }
    }
}