<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = User::where('role', 'driver')->paginate(10);
        return view('admin.drivers.index', compact('drivers'));
    }

    public function create()
    {
        return view('admin.drivers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'regex:/^[A-Za-z\s]{2,50}$/'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['required', 'regex:/^(\+94|0)[0-9]{9}$/'],
            'address' => ['nullable', 'string', 'max:255'],
            'license_number' => ['required', 'string', 'regex:/^[A-Za-z0-9]{5,15}$/'],
            'password' => ['required', 'min:8', 'confirmed'],
            'driver_photo' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
            'status' => ['required', 'in:active,inactive'],
        ], [
            'name.required' => 'Please enter the driver\'s full name.',
            'name.string' => 'The name must be a string.',
            'name.regex' => 'The name should be 2-50 characters long and contain only letters and spaces.',
            'email.required' => 'Please enter the driver\'s email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already in use.',
            'phone.required' => 'Please enter the driver\'s phone number.',
            'phone.regex' => 'Please enter a valid Sri Lankan phone number (e.g., 0771234567 or +94771234567).',
            'address.string' => 'The address must be a string.',
            'address.max' => 'The address cannot be longer than 255 characters.',
            'license_number.required' => 'Please enter the driver\'s license number.',
            'license_number.string' => 'The license number must be a string.',
            'license_number.regex' => 'The license number should be 5-15 alphanumeric characters.',
            'password.required' => 'Please enter a password.',
            'password.min' => 'The password must be at least 8 characters long.',
            'password.confirmed' => 'The password confirmation does not match.',
            'driver_photo.image' => 'The driver photo must be an image.',
            'driver_photo.mimes' => 'The driver photo must be a PNG, JPG, or JPEG file.',
            'driver_photo.max' => 'The driver photo cannot be larger than 2MB.',
            'status.required' => 'Please select the driver\'s status.',
            'status.in' => 'The status must be either active or inactive.',
        ]);

        $data['role'] = 'driver';
        $data['password'] = bcrypt($data['password']);

        if ($request->hasFile('driver_photo')) {
            $data['driver_photo'] = $request->file('driver_photo')->store('driver-photos', 'public');
        }

        User::create($data);

        return redirect()->route('admin.drivers.index')->with('success', 'Driver created successfully');
    }

    public function show(User $driver)
    {
        return view('admin.drivers.show', compact('driver'));
    }

    public function edit(User $driver)
    {
        return view('admin.drivers.edit', compact('driver'));
    }

    public function update(Request $request, User $driver)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'regex:/^[A-Za-z\s]{2,50}$/'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($driver->id)],
            'phone' => ['required', 'regex:/^(\+94|0)[0-9]{9}$/'],
            'address' => ['nullable', 'string', 'max:255'],
            'license_number' => ['required', 'string', 'regex:/^[A-Za-z0-9]{5,15}$/'],
            'driver_photo' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
            'status' => ['required', 'in:active,inactive'],
        ], [
            'name.required' => 'Please enter the driver\'s full name.',
            'name.string' => 'The name must be a string.',
            'name.regex' => 'The name should be 2-50 characters long and contain only letters and spaces.',
            'email.required' => 'Please enter the driver\'s email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already in use.',
            'phone.required' => 'Please enter the driver\'s phone number.',
            'phone.regex' => 'Please enter a valid Sri Lankan phone number (e.g., 0771234567 or +94771234567).',
            'address.string' => 'The address must be a string.',
            'address.max' => 'The address cannot be longer than 255 characters.',
            'license_number.required' => 'Please enter the driver\'s license number.',
            'license_number.string' => 'The license number must be a string.',
            'license_number.regex' => 'The license number should be 5-15 alphanumeric characters.',
            'driver_photo.image' => 'The driver photo must be an image.',
            'driver_photo.mimes' => 'The driver photo must be a PNG, JPG, or JPEG file.',
            'driver_photo.max' => 'The driver photo cannot be larger than 2MB.',
            'status.required' => 'Please select the driver\'s status.',
            'status.in' => 'The status must be either active or inactive.',
        ]);

        if ($request->hasFile('driver_photo')) {
            $data['driver_photo'] = $request->file('driver_photo')->store('driver-photos', 'public');
        }

        $driver->update($data);

        return redirect()->route('admin.drivers.index')->with('success', 'Driver updated successfully');
    }

    public function destroy(User $driver)
    {
        $driver->delete();
        return back()->with('success', 'Driver deleted successfully');
    }
}