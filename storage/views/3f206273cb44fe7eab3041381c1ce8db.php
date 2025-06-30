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
    <h1><?php echo e(ucfirst(str_replace('_', ' ', $report->report_type))); ?> SriTravel Report</h1>
    <p>Period: <?php echo e($report->start_date->format('M d, Y')); ?> - <?php echo e($report->end_date->format('M d, Y')); ?></p>
    <p>Generated on: <?php echo e($report->created_at->format('M d, Y h:i A')); ?></p>

    <h2>Bookings Summary</h2>
    <div class="summary">
        <div><strong>Total Bookings:</strong> <?php echo e($reportData['summary']['total_bookings']); ?></div>
        <div><strong>Confirmed Bookings:</strong> <?php echo e($reportData['summary']['confirmed_bookings']); ?></div>
        <div><strong>Pending Bookings:</strong> <?php echo e($reportData['summary']['pending_bookings']); ?></div>
        <div><strong>Cancelled Bookings:</strong> <?php echo e($reportData['summary']['cancelled_bookings']); ?></div>
        <div><strong>Completed Bookings:</strong> <?php echo e($reportData['summary']['completed_bookings']); ?></div>
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
            <?php $__currentLoopData = $reportData['bookings']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td>#<?php echo e($booking['id']); ?></td>
                <td><?php echo e($booking['customer_name']); ?></td>
                <td><?php echo e($booking['vehicle']); ?></td>
                <td><?php echo e(ucfirst($booking['status'])); ?></td>
                <td><?php echo e($booking['start_date']); ?></td>
                <td><?php echo e($booking['end_date']); ?></td>
                <td>Rs.<?php echo e(number_format($booking['total_amount'], 2)); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</body>
</html><?php /**PATH C:\Users\Dell\Desktop\sritravel\sritravel\resources\views/admin/reports/bookings.blade.php ENDPATH**/ ?>