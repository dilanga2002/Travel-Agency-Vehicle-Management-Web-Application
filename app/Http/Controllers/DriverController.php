<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DriverController extends Controller
{
    public function dashboard()
    {
        // Get the authenticated driver
        $driver = auth()->user();
        
        // Get today's assignments
        $todayAssignments = Booking::where('driver_id', $driver->id)
            ->whereBetween('start_date', [today()->startOfDay(), today()->endOfDay()])
            ->whereIn('status', ['confirmed', 'pending'])
            ->count();
            
        Log::debug('Today Assignments Count:', ['count' => $todayAssignments]);
            
        // Get completed trips
        $completedTrips = Booking::where('driver_id', $driver->id)
            ->where('status', 'completed')
            ->count();
            
        Log::debug('Completed Trips Count:', ['count' => $completedTrips]);
            
        // Get upcoming assignments (next 7 days)
        $upcomingAssignments = Booking::where('driver_id', $driver->id)
            ->with(['user', 'vehicle'])
            ->whereBetween('start_date', [today(), today()->addDays(7)])
            ->whereIn('status', ['confirmed', 'pending'])
            ->orderBy('start_date')
            ->limit(5)
            ->get();
            
        // Get recent activities (last 5 completed trips)
        $recentActivities = Booking::where('driver_id', $driver->id)
            ->where('status', 'completed')
            ->with(['user', 'vehicle'])
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();
            
        Log::debug('Recent Activities:', ['count' => $recentActivities->count()]);
        
        // Sample driver rating (in a real app, this would come from reviews)
        $driverRating = 4.8;
        
        return view('driver.dashboard', compact(
            'todayAssignments',
            'completedTrips',
            'driverRating',
            'upcomingAssignments',
            'recentActivities'
        ));
    }

    public function bookings()
    {
        // Get all bookings assigned to this driver
        $bookings = Booking::where('driver_id', auth()->id())
            ->with(['user', 'vehicle'])
            ->orderBy('start_date', 'desc')
            ->paginate(10);
            
        return view('driver.bookings.index', compact('bookings'));
    }

    public function showBooking(Booking $booking)
    {
        // Ensure the booking belongs to this driver
        if ($booking->driver_id !== auth()->id()) {
            abort(403);
        }
        
        // Load related data
        $booking->load(['user', 'vehicle']);
        
        return view('driver.bookings.show', compact('booking'));
    }
    
    public function markAsCompleted(Booking $booking)
    {
        // Ensure the booking belongs to this driver
        if ($booking->driver_id !== auth()->id()) {
            abort(403);
        }
        
        // Only confirmed bookings can be marked as completed
        if ($booking->status !== 'confirmed') {
            return back()->with('error', 'Only confirmed bookings can be marked as completed');
        }
        
        // Update the booking status
        $booking->update(['status' => 'completed']);
        
        return back()->with('success', 'Booking marked as completed successfully');
    }
}