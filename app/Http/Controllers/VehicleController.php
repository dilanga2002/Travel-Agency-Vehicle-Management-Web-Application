<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = Vehicle::where('available', true);

            // Apply vehicle type filter
            if ($request->has('types') && $request->types !== 'all') {
                $types = explode(',', $request->types);
                $query->whereIn('type', $types);
            }

            // Apply price range filter
            if ($request->has('min_price')) {
                $query->where('price_per_km', '>=', $request->min_price);
            }
            if ($request->has('max_price')) {
                $query->where('price_per_km', '<=', $request->max_price);
            }

            // Apply date range filter
            if ($request->has('start_date') && $request->has('end_date')) {
                $startDate = Carbon::parse($request->start_date);
                $endDate = Carbon::parse($request->end_date);

                // Validate date range
                if ($startDate->isFuture() && $endDate->gte($startDate)) {
                    $query->whereDoesntHave('bookings', function ($query) use ($startDate, $endDate) {
                        $query->where(function ($q) use ($startDate, $endDate) {
                            $q->whereBetween('start_date', [$startDate, $endDate])
                              ->orWhereBetween('end_date', [$startDate, $endDate])
                              ->orWhere(function ($q) use ($startDate, $endDate) {
                                  $q->where('start_date', '<=', $startDate)
                                    ->where('end_date', '>=', $endDate);
                              });
                        });
                    });
                }
            }

            $vehicles = $query->paginate(10);

            return view('vehicles.index', compact('vehicles'));
        } catch (\Exception $e) {
            Log::error('Error in index method: ', ['message' => $e->getMessage()]);
            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $vehicle = Vehicle::findOrFail($id);
            
            if (!$vehicle->available) {
                return redirect()->route('vehicles.index')->with('error', 'This vehicle is currently unavailable.');
            }

            return view('vehicles.show', compact('vehicle'));
        } catch (\Exception $e) {
            Log::error('Error in show method: ', ['message' => $e->getMessage()]);
            return redirect()->route('vehicles.index')->with('error', 'An unexpected error occurred. Please try again.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'make' => 'required|string|max:255|min:2',
                'model' => 'required|string|max:255|min:2',
                'year' => 'required|integer|min:1900|max:' . date('Y'),
                'registration_number' => [
                    'required',
                    'string',
                    'max:255',
                    'unique:vehicles',
                    'regex:/^(?:[A-Z]{2}\s[A-Z]{2,3}\s\d{4}|[A-Z]{2,3}[ -]?\d{2,4}|\d{2,3}-\d{4})$/i'
                ],
                'type' => 'required|in:car,cab,van,minibus,bus',
                'price_per_km' => 'required|numeric|min:0.0|max:9999.99',
                'description' => 'nullable|string|max:1000',
                'image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
                'passengers' => 'required|integer|min:1|max:50',
                'features' => 'nullable|array',
                'features.*' => 'string|max:50',
                'available' => 'nullable|boolean',
            ], [
                'make.required' => 'Please enter the vehicle make.',
                'make.min' => 'The make must be at least 2 characters.',
                'model.required' => 'Please enter the vehicle model.',
                'model.min' => 'The model must be at least 2 characters.',
                'year.required' => 'Please enter the manufacturing year.',
                'year.max' => 'The year must not be in the future.',
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
                'features.*.max' => 'Each feature must not exceed 50 characters.',
                'image.mimes' => 'The image must be a PNG, JPG, or JPEG file.',
                'image.max' => 'The image size must not exceed 2MB.',
            ]);

            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('vehicles/images', 'public');
            }

            $validated['available'] = $request->input('available', 0) ? 1 : 0;

            Vehicle::create($validated);

            return redirect()->route('vehicles.index')->with('success', 'Vehicle added successfully!');
        } catch (ValidationException $e) {
            Log::error('Validation error in store: ', ['errors' => $e->errors()]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error in store method: ', ['message' => $e->getMessage()]);
            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        try {
            $validated = $request->validate([
                'make' => 'required|string|max:255|min:2',
                'model' => 'required|string|max:255|min:2',
                'year' => 'required|integer|min:1900|max:' . date('Y'),
                'registration_number' => [
                    'required',
                    'string',
                    'max:255',
                    'unique:vehicles,registration_number,' . $vehicle->id,
                    'regex:/^(?:[A-Z]{2}\s[A-Z]{2,3}\s\d{4}|[A-Z]{2,3}[ -]?\d{2,4}|\d{2,3}-\d{4})$/i'
                ],
                'type' => 'required|in:car,cab,van,minibus,bus',
                'price_per_km' => 'required|numeric|min:0.0|max:9999.99',
                'description' => 'nullable|string|max:1000',
                'image' => 'nullable|image|mimes:png,jpg,jpeg|max:2000',
                'passengers' => 'required|integer|min:1|max:50',
                'features' => 'nullable|array',
                'features.*' => 'string|max:50',
                'available' => 'boolean'
            ], [
                'make.required' => 'Please enter the vehicle make.',
                'make.min' => 'The make must be at least 2 characters.',
                'model.required' => 'Please enter the vehicle model.',
                'model.min' => 'The model must be at least 2 characters.',
                'year.required' => 'Please enter the manufacturing year.',
                'year.max' => 'The year must not be in the future.',
                'registration_number.required' => 'Please enter the registration number.',
                'registration_number.unique' => 'This registration number is already in use.',
                'registration_number.regex' => 'The registration number must be in a valid Sri Lankan format (e.g., WP CAA 3214, WP QL 9904, WP 1234, WP-1234, 12-3456).',
                'type.required' => 'Please select a vehicle type.',
                'price_per_km.required' => 'Please enter the price per kilometer.',
                'price_per_km.min' => 'The price per kilometer must be at least 0.',
                'price_per_km.max' => 'The price per kilometer cannot exceed 9999.99.',
                'passengers.required' => 'Please enter the passenger capacity.',
                'passengers.integer' => 'The passenger capacity must be an integer.',
                'passengers.min' => 'The passenger capacity must be at least 1.',
                'passengers.max' => 'The passenger capacity cannot exceed 50.',
                'features.*.max' => 'Each feature must not exceed 50 characters.',
                'image.mimes' => 'The image must be a PNG, JPG, or JPEG file.',
                'image.max' => 'The image size must not exceed 2MB.',
            ]);

            if ($request->hasFile('image')) {
                if ($vehicle->image) {
                    Storage::disk('public')->delete($vehicle->image);
                }
                $validated['image'] = $request->file('image')->store('vehicles/images', 'public');
            }

            $validated['available'] = $request->input('available', false) ? 1 : 0;

            $vehicle->update($validated);

            return redirect()->route('vehicles.index')->with('success', 'Vehicle updated successfully!');
        } catch (ValidationException $e) {
            Log::error('Validation error in update: ', ['errors' => $e->errors()]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error in update method: ', ['message' => $e->getMessage()]);
            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        try {
            if ($vehicle->image) {
                Storage::disk('public')->delete($vehicle->image);
            }
            $vehicle->delete();
            return redirect()->back()->with('success', 'Vehicle deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Error in destroy method: ', ['message' => $e->getMessage()]);
            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.');
        }
    }
}