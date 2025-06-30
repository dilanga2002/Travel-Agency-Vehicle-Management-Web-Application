<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehicles = Vehicle::paginate(10);
        return view('admin.vehicles.index', compact('vehicles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.vehicles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            \Log::info('Store request data: ', $request->all());
            \Log::info('Attempting validation...');

            $validated = $request->validate([
                'make' => 'required|string|max:255|min:2',
                'model' => 'required|string|max:255|min:2',
                'year' => 'required|numeric|min:1900|max:2025',
                'registration_number' => [
                    'required',
                    'string',
                    'max:255',
                    'unique:vehicles',
                    'regex:/^(?:[A-Z]{2}\s[A-Z]{2,3}\s\d{4}|[A-Z]{2,3}[ -]?\d{2,4}|\d{2,3}-\d{4})$/i'
                ],
                'type' => 'required|in:car,cab,van,minibus,bus',
                'price_per_km' => 'required|numeric|min:0|max:9999.99',
                'passengers' => 'required|integer|min:1|max:50',
                'description' => 'nullable|string|max:1000',
                'image' => 'nullable|image|mimes:png,jpg,jpeg|max:5120',
                'features' => 'nullable|string|max:255',
                'available' => 'nullable|boolean',
            ], [
                'make.required' => 'Please enter the vehicle make.',
                'make.min' => 'The make must be at least 2 characters.',
                'model.required' => 'Please enter the vehicle model.',
                'model.min' => 'The model must be at least 2 characters.',
                'year.required' => 'Please enter the manufacturing year.',
                'year.between' => 'The year must be between 1900 and 2025.',
                'registration_number.required' => 'Please enter the registration number.',
                'registration_number.unique' => 'This registration number is already in use.',
                'registration_number.regex' => 'The registration number must be in a valid Sri Lankan format (e.g., WP CAA 3214, WP QL 9904, WP 1234, WP-1234, 12-3456).',
                'type.required' => 'Please select a vehicle type.',
                'price_per_km.required' => 'Please enter the price per kilometer.',
                'price_per_km.min' => 'The price per kilometer must be at least 0.',
                'price_per_km.max' => 'The price per kilometer cannot exceed 9999.99.',
                'passengers.required' => 'Please enter the passenger capacity.',
                'passengers.integer' => 'The passenger capacity must be a whole number.',
                'passengers.min' => 'The passenger capacity must be at least 1.',
                'passengers.max' => 'The passenger capacity cannot exceed 50.',
                'image.mimes' => 'The image must be a PNG, JPG, or JPEG file.',
                'image.max' => 'The image size must not exceed 5MB.',
            ]);

            \Log::info('Validated data: ', $validated);

            $imagePath = null;
            if ($request->hasFile('image')) {
                \Log::info('Processing image upload...');
                $imagePath = $request->file('image')->store('vehicles', 'public');
                \Log::info('Image path: ', ['path' => $imagePath]);
            }

            \Log::info('Creating vehicle...');
            $vehicle = Vehicle::create([
                'make' => $validated['make'],
                'model' => $validated['model'],
                'year' => (int)$validated['year'],
                'registration_number' => $validated['registration_number'],
                'type' => $validated['type'],
                'price_per_km' => (float)$validated['price_per_km'],
                'passengers' => (int)$validated['passengers'],
                'description' => $validated['description'],
                'image' => $imagePath,
                'features' => $validated['features'] ? array_map('trim', explode(',', $validated['features'])) : [],
                'available' => $request->input('available', 0) ? 1 : 0,
            ]);

            \Log::info('Vehicle created: ', ['id' => $vehicle->id]);

            return redirect()->route('admin.vehicles.index')->with('success', 'Vehicle added successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error: ', ['errors' => $e->errors(), 'input' => $request->all()]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Unexpected error in store method: ', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->withErrors(['error' => 'An unexpected error occurred. Please try again.'])->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehicle $vehicle)
    {
        return view('admin.vehicles.edit', compact('vehicle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        try {
            \Log::info('Update request data: ', $request->all());
            \Log::info('Attempting validation...');

            $validated = $request->validate([
                'make' => 'required|string|max:255|min:2',
                'model' => 'required|string|max:255|min:2',
                'year' => 'required|integer|min:1900|max:2025',
                'registration_number' => [
                    'required',
                    'string',
                    'max:255',
                    'unique:vehicles,registration_number,' . $vehicle->id,
                    'regex:/^(?:[A-Z]{2}\s[A-Z]{2,3}\s\d{4}|[A-Z]{2,3}[ -]?\d{2,4}|\d{2,3}-\d{4})$/i'
                ],
                'type' => 'required|in:car,cab,van,minibus,bus',
                'price_per_km' => 'required|numeric|min:0|max:9999.99',
                'passengers' => 'required|integer|min:1|max:50',
                'description' => 'nullable|string|max:1000',
                'image' => 'nullable|image|mimes:png,jpg,jpeg|max:5120',
                'features' => 'nullable|string|max:255',
                'available' => 'nullable|boolean',
            ], [
                'make.required' => 'Please enter the vehicle make.',
                'make.min' => 'The make must be at least 2 characters.',
                'model.required' => 'Please enter the vehicle model.',
                'model.min' => 'The model must be at least 2 characters.',
                'year.required' => 'Please enter the manufacturing year.',
                'year.between' => 'The year must be between 1900 and 2025.',
                'registration_number.required' => 'Please enter the registration number.',
                'registration_number.unique' => 'This registration number is already in use.',
                'registration_number.regex' => 'The registration number must be in a valid Sri Lankan format (e.g., WP CAA 3214, WP QL 9904, WP 1234, WP-1234, 12-3456).',
                'type.required' => 'Please select a vehicle type.',
                'price_per_km.required' => 'Please enter the price per kilometer.',
                'price_per_km.min' => 'The price per kilometer must be at least 0.',
                'price_per_km.max' => 'The price per kilometer cannot exceed 9999.99.',
                'passengers.required' => 'Please enter the passenger capacity.',
                'passengers.integer' => 'The passenger capacity must be a whole number.',
                'passengers.min' => 'The passenger capacity must be at least 1.',
                'passengers.max' => 'The passenger capacity cannot exceed 50.',
                'image.mimes' => 'The image must be a PNG, JPG, or JPEG file.',
                'image.max' => 'The image size must not exceed 5MB.',
            ]);

            \Log::info('Validated data: ', $validated);

            if ($request->hasFile('image')) {
                \Log::info('Processing image upload...');
                if ($vehicle->image) {
                    Storage::disk('public')->delete($vehicle->image);
                }
                $imagePath = $request->file('image')->store('vehicles', 'public');
                $validated['image'] = $imagePath;
                \Log::info('Image path: ', ['path' => $imagePath]);
            }

            $validated['features'] = $validated['features'] ? array_map('trim', explode(',', $validated['features'])) : [];
            $validated['available'] = $request->input('available', 0) ? 1 : 0;

            \Log::info('Updating vehicle...', ['id' => $vehicle->id]);
            $vehicle->update($validated);
            \Log::info('Vehicle updated: ', ['id' => $vehicle->id]);

            return redirect()->route('admin.vehicles.index')->with('success', 'Vehicle updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error: ', ['errors' => $e->errors(), 'input' => $request->all()]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Unexpected error in update method: ', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->withErrors(['error' => 'An unexpected error occurred. Please try again.'])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        try {
            \Log::info('Deleting vehicle...', ['id' => $vehicle->id]);
            if ($vehicle->image) {
                Storage::disk('public')->delete($vehicle->image);
            }
            $vehicle->delete();
            \Log::info('Vehicle deleted: ', ['id' => $vehicle->id]);

            return redirect()->route('admin.vehicles.index')->with('success', 'Vehicle deleted successfully.');
        } catch (\Exception $e) {
            \Log::error('Unexpected error in destroy method: ', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->withErrors(['error' => 'An unexpected error occurred. Please try again.']);
        }
    }

    /**
     * Toggle the availability status of the specified vehicle.
     */
    public function toggleAvailability(Vehicle $vehicle)
    {
        try {
            \Log::info('Toggling vehicle availability...', ['id' => $vehicle->id, 'current_available' => $vehicle->available]);
            $vehicle->update(['available' => !$vehicle->available]);
            \Log::info('Vehicle availability toggled: ', ['id' => $vehicle->id, 'new_available' => $vehicle->available]);

            return redirect()->route('admin.vehicles.show', $vehicle->id)->with('success', 'Vehicle availability updated successfully.');
        } catch (\Exception $e) {
            \Log::error('Unexpected error in toggleAvailability method: ', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->withErrors(['error' => 'An unexpected error occurred. Please try again.']);
        }
    }
}