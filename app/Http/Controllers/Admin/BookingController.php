<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Vehicle;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\BookingConfirmation;
use App\Notifications\BookingStatusChanged;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['vehicle', 'user', 'driver'])->latest();

        // Apply status filter if present
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $bookings = $query->paginate(10);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $booking->load(['vehicle', 'user', 'driver']);
        return view('admin.bookings.show', compact('booking'));
    }

    public function confirm(Booking $booking)
    {
        try {
            $booking->update(['status' => 'confirmed']);
            
            // Send both confirmation and status change notifications
            $booking->user->notify(new BookingConfirmation($booking));
            $booking->user->notify(new BookingStatusChanged($booking, 'confirmed'));
            
            return redirect()->back()->with('success', 'Booking confirmed successfully');
        } catch (\Exception $e) {
            Log::error('Booking confirmation failed: '.$e->getMessage());
            return redirect()->back()->with('error', 'Failed to confirm booking');
        }
    }

    public function cancel(Booking $booking)
    {
        try {
            $booking->update(['status' => 'cancelled']);
            
            // Notify user with detailed cancellation reason if needed
            $booking->user->notify(new BookingStatusChanged($booking, 'cancelled'));
            
            return redirect()->back()->with('success', 'Booking cancelled successfully');
        } catch (\Exception $e) {
            Log::error('Booking cancellation failed: '.$e->getMessage());
            return redirect()->back()->with('error', 'Failed to cancel booking');
        }
    }

    public function complete(Booking $booking)
    {
        try {
            $booking->update(['status' => 'completed']);
            
            // Notify user of completion
            $booking->user->notify(new BookingStatusChanged($booking, 'completed'));
            
            return redirect()->back()->with('success', 'Booking marked as completed');
        } catch (\Exception $e) {
            Log::error('Booking completion failed: '.$e->getMessage());
            return redirect()->back()->with('error', 'Failed to complete booking');
        }
    }
}