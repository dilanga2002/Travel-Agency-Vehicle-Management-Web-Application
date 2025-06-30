<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bookings Report</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1, h2 { color: #1E3A8A; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .summary { margin-top: 20px; }
        .summary div { margin-bottom: 10px; }
    </style>
</head>
<body>
    <h1>{{ ucfirst(str_replace('_', ' ', $report->report_type)) }} SriTravel Report</h1>
    <p>Period: {{ $report->start_date->format('M d, Y') }} - {{ $report->end_date->format('M d, Y') }}</p>
    <p>Generated on: {{ $report->created_at->format('M d, Y h:i A') }}</p>

    <h2>Bookings Summary</h2>
    <div class="summary">
        <div><strong>Total Bookings:</strong> {{ $reportData['summary']['total_bookings'] }}</div>
        <div><strong>Confirmed Bookings:</strong> {{ $reportData['summary']['confirmed_bookings'] }}</div>
        <div><strong>Pending Bookings:</strong> {{ $reportData['summary']['pending_bookings'] }}</div>
        <div><strong>Cancelled Bookings:</strong> {{ $reportData['summary']['cancelled_bookings'] }}</div>
        <div><strong>Completed Bookings:</strong> {{ $reportData['summary']['completed_bookings'] }}</div>
    </div>

    <h2>Booking Details</h2>
    <table>
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>Customer</th>
                <th>Vehicle</th>
                <th>Status</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reportData['bookings'] as $booking)
            <tr>
                <td>#{{ $booking['id'] }}</td>
                <td>{{ $booking['customer_name'] }}</td>
                <td>{{ $booking['vehicle'] }}</td>
                <td>{{ ucfirst($booking['status']) }}</td>
                <td>{{ $booking['start_date'] }}</td>
                <td>{{ $booking['end_date'] }}</td>
                <td>Rs.{{ number_format($booking['total_amount'], 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>