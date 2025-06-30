<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vehicle Usage Report</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1, h2 { color: #1E3A8A; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>{{ ucfirst(str_replace('_', ' ', $report->report_type)) }}SriTravel Report</h1>
    <p>Period: {{ $report->start_date->format('M d, Y') }} - {{ $report->end_date->format('M d, Y') }}</p>
    <p>Generated on: {{ $report->created_at->format('M d, Y h:i A') }}</p>

    <h2>Vehicle Usage Details</h2>
    <table>
        <thead>
            <tr>
                <th>Vehicle</th>
                <th>Type</th>
                <th>Registration</th>
                <th>Bookings Count</th>
                <th>Days Rented</th>
                <th>Utilization</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reportData['vehicle_usage'] as $vehicle)
            <tr>
                <td>{{ $vehicle['make'] }} {{ $vehicle['model'] }}</td>
                <td>{{ $vehicle['type'] }}</td>
                <td>{{ $vehicle['registration_number'] }}</td>
                <td>{{ $vehicle['bookings_count'] }}</td>
                <td>{{ $vehicle['days_rented'] }}</td>
                <td>{{ number_format($vehicle['utilization'], 1) }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Most Used Vehicle Types</h2>
    <table>
        <thead>
            <tr>
                <th>Vehicle Type</th>
                <th>Total Bookings</th>
                <th>Total Days Rented</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reportData['type_usage'] as $type)
            <tr>
                <td>{{ $type['type'] }}</td>
                <td>{{ $type['total_bookings'] }}</td>
                <td>{{ $type['total_days_rented'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>