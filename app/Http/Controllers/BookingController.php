<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Vehicle;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Notifications\BookingConfirmation;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = auth()->user()->bookings()->latest();

        // Apply status filter if provided
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $bookings = $query->paginate(10);

        // Append query parameters to pagination links
        $bookings->appends($request->only('status'));

        return view('bookings.index', compact('bookings'));
    }

    public function create(Vehicle $vehicle)
    {
        $drivers = User::where('role', 'driver')->where('status', 'active')->get();
        return view('bookings.create', compact('vehicle', 'drivers'));
    }

    public function store(Request $request)
    {
        \Log::info('Received request data: ', $request->all());

        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'start_date' => 'required|date|after_or_equal:' . now()->addDay()->toDateString(),
            'end_date' => 'required|date|after_or_equal:start_date',
            'pickup_time' => 'required',
            'pickup_location' => 'required|string|max:255',
            'dropoff_location' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'total_KiloMeter' => 'required|integer|min:1',
            'driver_id' => 'nullable|exists:users,id,role,driver,status,active',
            'special_requests' => 'nullable|string|max:500',
            'price_per_km' => 'required|numeric|min:0',
        ], [
            'vehicle_id.required' => 'Please select a vehicle.',
            'start_date.after_or_equal' => 'The start date must be tomorrow or later.',
            'end_date.after_or_equal' => 'The end date must be on or after the start date.',
            'pickup_time.required' => 'Please specify a pickup time.',
            'pickup_location.required' => 'Please enter a pickup location.',
            'dropoff_location.required' => 'Please enter a dropoff location.',
            'destination.required' => 'Please enter a destination.',
            'total_KiloMeter.min' => 'Total kilometers must be at least 1.',
            'driver_id.exists' => 'The selected driver is invalid or inactive.',
            'price_per_km.required' => 'Price per kilometer is required.',
            'price_per_km.numeric' => 'Price per kilometer must be a valid number.',
        ]);

        \Log::info('Validated data: ', $validated);

        $vehicle = Vehicle::findOrFail($validated['vehicle_id']);

        // Check vehicle availability
        $vehicleAvailable = !Booking::where('vehicle_id', $vehicle->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
                      ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']])
                      ->orWhere(function ($q) use ($validated) {
                          $q->where('start_date', '<=', $validated['start_date'])
                            ->where('end_date', '>=', $validated['end_date']);
                      });
            })
            ->exists();

        if (!$vehicleAvailable) {
            throw ValidationException::withMessages([
                'start_date' => 'This vehicle is not available for the selected dates.',
            ]);
        }

        // Check driver availability if driver_id is provided
        if ($validated['driver_id']) {
            $driverAvailable = !Booking::where('driver_id', $validated['driver_id'])
                ->whereIn('status', ['pending', 'confirmed'])
                ->where(function ($query) use ($validated) {
                    $query->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
                          ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']])
                          ->orWhere(function ($q) use ($validated) {
                              $q->where('start_date', '<=', $validated['start_date'])
                                ->where('end_date', '>=', $validated['end_date']);
                          });
                })
                ->exists();

            if (!$driverAvailable) {
                throw ValidationException::withMessages([
                    'driver_id' => 'This driver is not available for the selected dates.',
                ]);
            }
        }

        $startDate = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['end_date']);
        $totalDays = $startDate->diffInDays($endDate) + 1; // Include both start and end dates
        $totalAmount = $totalDays * $validated['total_KiloMeter'] * $validated['price_per_km'];

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'vehicle_id' => $vehicle->id,
            'driver_id' => $validated['driver_id'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'pickup_time' => $validated['pickup_time'],
            'pickup_location' => $validated['pickup_location'],
            'dropoff_location' => $validated['dropoff_location'],
            'destination' => $validated['destination'],
            'total_KiloMeter' => $validated['total_KiloMeter'],
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'special_requests' => $validated['special_requests'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        \Log::info('Booking created: ', $booking->toArray());

        auth()->user()->notify(new BookingConfirmation($booking));

        return redirect()->route('bookings.show', $booking)->with('success', 'Booking created successfully!');
    }

    public function edit(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $drivers = User::where('role', 'driver')->where('status', 'active')->get();
        return view('bookings.edit', compact('booking', 'drivers'));
    }

    public function update(Request $request, Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'start_date' => 'required|date|after_or_equal:' . now()->toDateString(),
            'end_date' => 'required|date|after_or_equal:start_date',
            'pickup_time' => 'required',
            'pickup_location' => 'required|string|max:255',
            'dropoff_location' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'total_KiloMeter' => 'required|integer|min:1',
            'driver_id' => 'nullable|exists:users,id,role,driver,status,active',
            'special_requests' => 'nullable|string|max:500',
        ], [
            'start_date.after_or_equal' => 'The start date cannot be in the past.',
            'end_date.after_or_equal' => 'The end date must be on or after the start date.',
            'pickup_time.required' => 'Please specify a pickup time.',
            'pickup_location.required' => 'Please enter a pickup location.',
            'dropoff_location.required' => 'Please enter a drop-off location.',
            'destination.required' => 'Please enter a destination.',
            'total_KiloMeter.min' => 'Total kilometers must be at least 1.',
            'driver_id.exists' => 'The selected driver is invalid or inactive.',
        ]);

        $startDate = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['end_date']);
        $totalDays = $startDate->diffInDays($endDate) + 1; // Include both start and end dates
        $pricePerKm = $booking->vehicle->price_per_km;
        $totalAmount = $totalDays * $validated['total_KiloMeter'] * $pricePerKm;

        // Check vehicle availability, excluding the current booking
        $vehicleAvailable = !Booking::where('vehicle_id', $booking->vehicle_id)
            ->where('id', '!=', $booking->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
                      ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']])
                      ->orWhere(function ($q) use ($validated) {
                          $q->where('start_date', '<=', $validated['start_date'])
                            ->where('end_date', '>=', $validated['end_date']);
                      });
            })
            ->exists();

        if (!$vehicleAvailable) {
            throw ValidationException::withMessages([
                'start_date' => 'This vehicle is not available for the selected dates.',
            ]);
        }

        // Check driver availability if driver_id is provided, excluding the current booking
        if ($validated['driver_id']) {
            $driverAvailable = !Booking::where('driver_id', $validated['driver_id'])
                ->where('id', '!=', $booking->id)
                ->whereIn('status', ['pending', 'confirmed'])
                ->where(function ($query) use ($validated) {
                    $query->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
                          ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']])
                          ->orWhere(function ($q) use ($validated) {
                              $q->where('start_date', '<=', $validated['start_date'])
                                ->where('end_date', '>=', $validated['end_date']);
                          });
                })
                ->exists();

            if (!$driverAvailable) {
                throw ValidationException::withMessages([
                    'driver_id' => 'This driver is not available for the selected dates.',
                ]);
            }
        }

        $booking->update([
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'pickup_time' => $validated['pickup_time'],
            'pickup_location' => $validated['pickup_location'],
            'dropoff_location' => $validated['dropoff_location'],
            'destination' => $validated['destination'],
            'total_KiloMeter' => $validated['total_KiloMeter'],
            'total_amount' => $totalAmount,
            'driver_id' => $validated['driver_id'],
            'special_requests' => $validated['special_requests'],
            'updated_at' => now(),
        ]);

        return redirect()->route('bookings.show', $booking)->with('success', 'Booking updated successfully!');
    }

    public function show($id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('bookings.show', compact('booking'));
    }

    public function cancel(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $booking->update(['status' => 'cancelled']);
        return back()->with('success', 'Booking cancelled successfully!');
    }

    public function checkDriverAvailability(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $drivers = User::where('role', 'driver')
            ->where('status', 'active')
            ->get()
            ->map(function ($driver) use ($validated) {
                $isAvailable = !Booking::where('driver_id', $driver->id)
                    ->whereIn('status', ['pending', 'confirmed'])
                    ->where(function ($query) use ($validated) {
                        $query->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
                            ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']])
                            ->orWhere(function ($q) use ($validated) {
                                $q->where('start_date', '<=', $validated['start_date'])
                                    ->where('end_date', '>=', $validated['end_date']);
                            });
                    })
                    ->exists();

                return [
                    'id' => $driver->id,
                    'name' => $driver->name,
                    'license_number' => $driver->license_number,
                    'is_available' => $isAvailable,
                ];
            });

        return response()->json(['drivers' => $drivers]);
    }
}