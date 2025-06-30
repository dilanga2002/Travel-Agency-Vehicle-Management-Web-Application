<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Report;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        $now = Carbon::now();
        
        $totalBookings = Booking::where('created_at', '>=', $now->startOfMonth())
            ->count();
            
        $totalRevenue = Booking::where('status', 'confirmed')
            ->where('created_at', '>=', $now->startOfMonth())
            ->sum('total_amount');
            
        $totalVehicles = Vehicle::count();
        $bookedVehicles = Booking::where('status', 'confirmed')
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->distinct('vehicle_id')
            ->count('vehicle_id');
            
        $utilizationRate = $totalVehicles > 0 
            ? round(($bookedVehicles / $totalVehicles) * 100, 2) 
            : 0;
        
        // Handle sorting
        $sort = $request->query('sort', 'newest');
        $sortDirection = $sort === 'oldest' ? 'asc' : 'desc';
        
        $recentReports = Report::orderBy('created_at', $sortDirection)
            ->take(5)
            ->get();

        return view('admin.reports.index', compact(
            'totalBookings',
            'totalRevenue',
            'utilizationRate',
            'recentReports'
        ));
    }

    public function generate(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'report_type' => 'required|in:bookings,vehicle_usage',
            'start_date' => 'required|date|before_or_equal:today',
            'end_date' => 'required|date|after:start_date|before_or_equal:today',
        ], [
            'report_type.required' => 'Please select a report type.',
            'report_type.in' => 'Invalid report type selected.',
            'start_date.required' => 'Please select a start date.',
            'start_date.date' => 'Start date must be a valid date.',
            'start_date.before_or_equal' => 'Start date cannot be in the future.',
            'end_date.required' => 'Please select an end date.',
            'end_date.date' => 'End date must be a valid date.',
            'end_date.after' => 'End date must be after the start date.',
            'end_date.before_or_equal' => 'End date cannot be in the future.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please correct the errors below and try again.');
        }

        try {
            $validated = $validator->validated();
            $reportData = match ($validated['report_type']) {
                'bookings' => $this->generateBookingsReport(
                    Carbon::parse($validated['start_date']),
                    Carbon::parse($validated['end_date'])
                ),
                'vehicle_usage' => $this->generateVehicleUsageReport(
                    Carbon::parse($validated['start_date']),
                    Carbon::parse($validated['end_date'])
                ),
            };

            Log::info('Report data before encoding: ', $reportData);

            $report = Report::create([
                'admin_id' => auth()->id(),
                'report_type' => $validated['report_type'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'data' => json_encode($reportData)
            ]);

            return redirect()->route('admin.reports.download', $report)
                ->with('success', 'Report generated successfully');
        } catch (\Exception $e) {
            Log::error('Report generation failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to generate report. Please try again.');
        }
    }

    public function download(Report $report)
    {
        try {
            Log::info('Raw report data for report ID ' . $report->id . ': ', ['data' => $report->data]);

            $reportData = $report->data;
            if (is_string($reportData)) {
                $decodedData = json_decode($reportData, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    Log::error('JSON decode error for report ID ' . $report->id . ': ' . json_last_error_msg());
                    throw new \RuntimeException('Invalid JSON format in report data');
                }
                $reportData = $decodedData;
            }

            if (is_null($reportData) || !is_array($reportData)) {
                Log::error('Invalid report data format for report ID: ' . $report->id);
                throw new \RuntimeException('Invalid report data format');
            }

            $pdfView = match ($report->report_type) {
                'bookings' => $this->generateBookingsPdf($report, $reportData),
                'vehicle_usage' => $this->generateVehicleUsagePdf($report, $reportData),
                default => throw new \Exception('Invalid report type: ' . $report->report_type),
            };

            return $pdfView->download('report_' . $report->id . '.pdf');
        } catch (\Exception $e) {
            Log::error('PDF generation error for report ID ' . $report->id . ': ' . $e->getMessage());
            return redirect()->route('admin.reports.index')
                ->with('error', 'Error generating PDF report. Please try again.');
        }
    }

    public function destroy(Report $report): RedirectResponse
    {
        try {
            $report->delete();
            return redirect()->route('admin.reports.index')
                ->with('success', 'Report deleted successfully');
        } catch (\Exception $e) {
            Log::error('Report deletion failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete report. Please try again.');
        }
    }

    protected function generateBookingsReport(Carbon $start, Carbon $end): array
    {
        $bookings = Booking::with('vehicle', 'user')
            ->whereBetween('created_at', [$start, $end])
            ->get()
            ->map(function ($booking) {
                return [
                    'id' => $booking->id,
                    'customer_name' => $booking->user->name ?? 'Unknown',
                    'vehicle' => $booking->vehicle->make . ' ' . $booking->vehicle->model ?? 'Unknown',
                    'status' => $booking->status,
                    'start_date' => $booking->start_date->format('M d, Y'),
                    'end_date' => $booking->end_date->format('M d, Y'),
                    'total_amount' => $booking->total_amount,
                ];
            })->toArray();

        $summary = Booking::whereBetween('created_at', [$start, $end])
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->get()
            ->mapWithKeys(fn ($item) => [$item['status'] => $item['count']])
            ->toArray();

        return [
            'bookings' => $bookings,
            'summary' => [
                'total_bookings' => array_sum($summary),
                'confirmed_bookings' => $summary['confirmed'] ?? 0,
                'pending_bookings' => $summary['pending'] ?? 0,
                'cancelled_bookings' => $summary['cancelled'] ?? 0,
                'completed_bookings' => $summary['completed'] ?? 0,
            ],
        ];
    }

    protected function generateVehicleUsageReport(Carbon $start, Carbon $end): array
    {
        $bookings = Booking::with('vehicle')
            ->whereBetween('created_at', [$start, $end])
            ->where('status', 'confirmed')
            ->selectRaw('vehicle_id, count(*) as bookings_count')
            ->groupBy('vehicle_id')
            ->get();

        $vehicleUsage = $bookings->map(function ($item) use ($start, $end) {
            $daysRented = Booking::where('vehicle_id', $item->vehicle_id)
                ->whereBetween('created_at', [$start, $end])
                ->where('status', 'confirmed')
                ->sum(\DB::raw('DATEDIFF(end_date, start_date) + 1'));
            $totalDays = $start->diffInDays($end) + 1;
            $utilization = $totalDays > 0 ? ($daysRented / $totalDays) * 100 : 0;

            return [
                'vehicle_id' => $item->vehicle_id,
                'make' => $item->vehicle->make ?? 'Unknown',
                'model' => $item->vehicle->model ?? 'Unknown',
                'type' => $item->vehicle->type ?? 'Unknown',
                'registration_number' => $item->vehicle->registration_number ?? 'Unknown',
                'bookings_count' => $item->bookings_count,
                'days_rented' => $daysRented,
                'utilization' => round($utilization, 1),
            ];
        })->toArray();

        $typeUsage = collect($vehicleUsage)
            ->groupBy('type')
            ->map(function ($group) {
                return [
                    'type' => $group->first()['type'],
                    'total_bookings' => $group->sum('bookings_count'),
                    'total_days_rented' => $group->sum('days_rented'),
                ];
            })->sortByDesc('total_bookings')
            ->values()
            ->toArray();

        return [
            'vehicle_usage' => $vehicleUsage,
            'type_usage' => $typeUsage,
        ];
    }

    protected function generateBookingsPdf(Report $report, array $reportData)
    {
        $pdf = Pdf::loadView('admin.reports.bookings', [
            'report' => $report,
            'reportData' => $reportData,
        ]);
        return $pdf;
    }

    protected function generateVehicleUsagePdf(Report $report, array $reportData)
    {
        $pdf = Pdf::loadView('admin.reports.vehicle_usage', [
            'report' => $report,
            'reportData' => $reportData,
        ]);
        return $pdf;
    }
}