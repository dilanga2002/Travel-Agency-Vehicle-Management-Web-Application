<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class DriverProfileController extends Controller
{
    public function show()
    {
        $driver = Auth::user();
        return view('driver.profile.edit', compact('driver'));
    }

    public function update(Request $request)
    {
        $driver = Auth::user();

        // Validation rules
        $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users,email,' . $driver->id],
            'phone' => ['nullable', 'string', 'max:20', 'regex:/^(?:\+94|0)[1-9][0-9]{8}$/'],
            'address' => ['nullable', 'string', 'max:255'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'license_number' => ['nullable', 'string', 'max:50', 'regex:/^[A-Z0-9\-]+$/'],
            'status' => ['nullable', 'in:active,inactive'],
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
            'profile_photo.max' => 'The profile photo is too large. Please use a file smaller than 2MB.',
            'license_number.max' => 'The license number is too long. Please use up to 50 characters.',
            'license_number.regex' => 'The license number should only contain letters, numbers, or hyphens.',
            'status.in' => 'Status must be either active or inactive.',
            'current_password.required_with' => 'Please enter your current password to change your password.',
            'current_password.current_password' => 'The current password you entered is incorrect.',
            'password.min' => 'Your new password must be at least 8 characters long.',
            'password.confirmed' => 'The new password and confirmation do not match.',
        ]);

        try {
            $data = [];

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
            if ($request->filled('license_number')) {
                $data['license_number'] = $request->license_number;
            }
            if ($request->filled('status')) {
                $data['status'] = $request->status;
            }

            if ($request->hasFile('profile_photo')) {
                if ($driver->profile_photo) {
                    Storage::disk('public')->delete($driver->profile_photo);
                }
                $path = $request->file('profile_photo')->store('profile_photos', 'public');
                $data['profile_photo'] = $path;
            }

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            if (!empty($data)) {
                $driver->update($data);
                return redirect()->back()->with('success', 'Profile updated successfully!');
            }

            return redirect()->back()->with('error', 'No changes were made to your profile.');
        } catch (\Exception $e) {
            Log::error('Driver profile update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Sorry, we couldn’t update your profile. Please try again.');
        }
    }
}