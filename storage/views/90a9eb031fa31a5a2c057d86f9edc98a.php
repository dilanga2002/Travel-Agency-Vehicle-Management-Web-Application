<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="<?php echo e(asset('images/favicon-32x32.png')); ?>">
    <title>SriTravel - Admin Booking Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            900: '#1E3A8A',
                            800: '#1E40AF',
                            700: '#1E4BB5',
                            600: '#2563EB',
                            500: '#3B82F6',
                        },
                        accent: {
                            500: '#3B82F6',
                            600: '#2563EB',
                        }
                    },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                        heading: ['Playfair Display', 'serif'],
                    },
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            transition: all 0.3s;
            position: fixed;
            height: 100%;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            background-color: #1E3A8A;
            color: white;
        }

        .sidebar-header {
            padding: 1.25rem;
        }

        .sidebar-menu {
            padding: 1.25rem 0;
        }

        .sidebar-menu ul {
            list-style: none;
        }

        .sidebar-menu li a {
            display: block;
            padding: 0.9375rem 1.25rem;
            text-decoration: none;
            transition: all 0.3s;
            color: #BFDBFE;
        }

        .sidebar-menu li a:hover {
            background-color: #1E40AF;
            color: white;
        }

        .sidebar-menu li a i {
            margin-right: 0.625rem;
            width: 1.25rem;
            text-align: center;
        }

        .main-content {
            margin-left: 250px;
            width: calc(100% - 250px);
            padding: 1.25rem;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }
            .main-content {
                margin-left: 200px;
                width: calc(100% - 200px);
            }
        }

        @media (max-width: 480px) {
            .sidebar {
                width: 100%;
                position: static;
            }
            .main-content {
                margin-left: 0;
                width: 100%;
            }
        }
        
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .status-confirmed {
            background-color: #D1FAE5;
            color: #065F46;
        }
        
        .status-pending {
            background-color: #FEF3C7;
            color: #92400E;
        }
        
        .status-cancelled {
            background-color: #FEE2E2;
            color: #991B1B;
        }
        
        .status-completed {
            background-color: #E0E7FF;
            color: #3730A3;
        }
        
        .timeline {
            position: relative;
            padding-left: 1.5rem;
        }
        
        .timeline::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 2px;
            background-color: #E5E7EB;
        }
        
        .timeline-item {
            position: relative;
            padding-bottom: 1.5rem;
        }
        
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -1.5rem;
            top: 0.25rem;
            width: 0.75rem;
            height: 0.75rem;
            border-radius: 9999px;
            background-color: #3B82F6;
            border: 2px solid white;
        }
    </style>
</head>
<body class="font-sans bg-gray-50">
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar bg-blue-900 text-white">
            <div class="sidebar-header">
                <h2 class="text-xl font-bold font-heading flex items-center">
                    <i class="fas fa-car text-blue-400 mr-2"></i>
                    SriTravel
                </h2>
                <p class="text-sm text-blue-200">Admin Panel</p>
            </div>
            
            <div class="p-4 border-b border-blue-800 flex items-center">
               <img class="h-10 w-10 rounded-full mr-3" src="<?php echo e(auth()->user()->profile_photo ? asset('storage/'.auth()->user()->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=random'); ?>" alt="<?php echo e(auth()->user()->name); ?> avatar">
                <div>
                    <p class="font-medium"><?php echo e(auth()->user()->name); ?></p>
                    <p class="text-blue-200 text-xs"><?php echo e(auth()->user()->email); ?></p>
                </div>
            </div>
            
            <div class="sidebar-menu">
                <ul>
                    <li>
                        <a href="/" class="text-blue-200 hover:text-white hover:bg-blue-700 flex items-center">
                            <i class="fas fa-home"></i> Home
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="text-blue-200 hover:text-white hover:bg-blue-700 flex items-center">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('admin.vehicles.index')); ?>" class="text-blue-200 hover:text-white hover:bg-blue-700 flex items-center">
                            <i class="fas fa-car"></i> Vehicles
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('admin.drivers.index')); ?>" class="text-blue-200 hover:text-white hover:bg-blue-700 flex items-center">
                            <i class="fas fa-users"></i> Drivers
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('admin.bookings.index')); ?>" class="text-white bg-blue-700 border-l-4 border-blue-400 flex items-center">
                            <i class="fas fa-calendar-check"></i> Bookings
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('admin.reports.index')); ?>" class="text-blue-200 hover:text-white hover:bg-blue-700 flex items-center">
                            <i class="fas fa-chart-bar"></i> Reports
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('admin.profile.show')); ?>" class="text-blue-200 hover:text-white hover:bg-blue-700 flex items-center">
                            <i class="fas fa-user"></i> Profile
                        </a>
                    </li>
                    
                </ul>
            </div>
            <div class="sidebar-footer p-4">
        <form method="POST" action="<?php echo e(route('logout')); ?>">
            <?php echo csrf_field(); ?>
            <a href="<?php echo e(route('logout')); ?>" class="bg-red-500 !bg-red-500 text-white !text-white hover:bg-red-600 hover:!bg-red-600 hover:text-white hover:!text-white flex items-center w-full px-4 py-2 rounded-md text-sm font-medium" onclick="event.preventDefault(); this.closest('form').submit();">
                <i class="fas fa-sign-out-alt mr-2"></i> Logout
            </a>
        </form>
    </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <header class="bg-white shadow-md rounded-lg p-4 flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-semibold font-heading text-gray-800">Booking Bk-<?php echo e($booking->id); ?></h1>
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <a href="<?php echo e(route('admin.dashboard')); ?>" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                                    <i class="fas fa-home mr-2"></i>
                                    Home
                                </a>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                                    <a href="<?php echo e(route('admin.bookings.index')); ?>" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Bookings</a>
                                </div>
                            </li>
                            <li aria-current="page">
                                <div class="flex items-center">
                                    <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Booking Details</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="flex space-x-2">
                    <?php if($booking->status == 'pending'): ?>
                        <form action="<?php echo e(route('admin.bookings.confirm', $booking->id)); ?>" method="POST" class="inline">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:border-green-800 focus:ring focus:ring-green-200 disabled:opacity-25 transition">
                                <i class="fas fa-check mr-2"></i> Accept Booking
                            </button>
                        </form>
                        <form action="<?php echo e(route('admin.bookings.cancel', $booking->id)); ?>" method="POST" class="inline">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-800 focus:outline-none focus:border-red-800 focus:ring focus:ring-red-200 disabled:opacity-25 transition">
                                <i class="fas fa-times mr-2"></i> Reject Booking
                            </button>
                        </form>
                    <?php endif; ?>
                    <a href="<?php echo e(route('admin.bookings.index')); ?>" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-200 active:bg-gray-300 focus:outline-none focus:border-gray-300 focus:ring focus:ring-gray-200 disabled:opacity-25 transition">
                        <i class="fas fa-arrow-left mr-2"></i> Back to Bookings
                    </a>
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Booking Details -->
                    <div class="lg:col-span-2">
                        <div class="bg-white shadow rounded-xl p-6">
                            <div class="flex justify-between items-start mb-6">
                                <h2 class="text-lg font-medium text-gray-800">Booking Information</h2>
                                <div>
                                    <?php if($booking->status == 'confirmed'): ?>
                                        <span class="status-badge status-confirmed">
                                            <i class="fas fa-check-circle mr-1"></i> Confirmed
                                        </span>
                                    <?php elseif($booking->status == 'pending'): ?>
                                        <span class="status-badge status-pending">
                                            <i class="fas fa-clock mr-1"></i> Pending
                                        </span>
                                    <?php elseif($booking->status == 'cancelled'): ?>
                                        <span class="status-badge status-cancelled">
                                            <i class="fas fa-times-circle mr-1"></i> Cancelled
                                        </span>
                                    <?php else: ?>
                                        <span class="status-badge status-completed">
                                            <i class="fas fa-check-double mr-1"></i> Completed
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Customer Information -->
                                <div class="md:col-span-2">
                                    <h3 class="text-sm font-medium text-gray-500 mb-2">Customer Details</h3>
                                    <div class="flex items-center p-4 border border-gray-200 rounded-lg">
                                        <div class="flex-shrink-0 h-16 w-16">
                                            <img class="h-16 w-16 rounded-full object-cover" src="<?php echo e($booking->user->profile_photo ? asset('storage/' . $booking->user->profile_photo) : asset('images/customer-placeholder.jpg')); ?>" alt="<?php echo e($booking->user->name); ?>">
                                        </div>
                                        <div class="ml-4">
                                            <h3 class="text-lg font-medium text-gray-900"><?php echo e($booking->user->name); ?></h3>
                                            <div class="text-sm text-gray-500"><?php echo e($booking->user->email); ?></div>
                                            <div class="text-sm text-gray-500"><?php echo e($booking->user->phone ?? 'No phone provided'); ?></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Vehicle Information -->
                                <div class="md:col-span-2">
                                    <h3 class="text-sm font-medium text-gray-500 mb-2">Vehicle Details</h3>
                                    <div class="flex items-center p-4 border border-gray-200 rounded-lg">
                                        <div class="flex-shrink-0 h-20 w-20">
                                            <img class="h-20 w-20 rounded-md object-cover" src="<?php echo e($booking->vehicle->image ? asset('storage/'.$booking->vehicle->image) : asset('images/vehicle-placeholder.jpg')); ?>" alt="<?php echo e($booking->vehicle->make); ?> <?php echo e($booking->vehicle->model); ?>">
                                        </div>
                                        <div class="ml-4">
                                            <h3 class="text-lg font-medium text-gray-900"><?php echo e($booking->vehicle->make); ?> <?php echo e($booking->vehicle->model); ?></h3>
                                            <div class="text-sm text-gray-500"><?php echo e($booking->vehicle->year); ?> • <?php echo e($booking->vehicle->registration_number); ?></div>
                                            <div class="mt-1">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    <?php echo e(ucfirst($booking->vehicle->type)); ?>

                                                </span>
                                            </div>
                                        </div>
                                        <div class="ml-auto text-right">
                                            <div class="text-lg font-bold text-blue-600">Rs. <?php echo e(number_format($booking->vehicle->price_per_km, 2)); ?></div>
                                            <div class="text-sm text-gray-500">per 1km</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Booking Dates -->
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500 mb-2">Rental Period</h3>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <div class="text-sm text-gray-500">Start Date</div>
                                                <div class="font-medium"><?php echo e($booking->start_date->format('M d, Y')); ?></div>
                                            </div>
                                            <div class="text-gray-400 mx-2">
                                                <i class="fas fa-arrow-right"></i>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-sm text-gray-500">End Date</div>
                                                <div class="font-medium"><?php echo e($booking->end_date->format('M d, Y')); ?></div>
                                            </div>
                                        </div>
                                        <div class="mt-3 pt-3 border-t border-gray-200 text-center">
                                            <div class="text-sm text-gray-500">Total Rental Days</div>
                                            <div class="font-medium"><?php echo e($booking->total_days); ?> day<?php echo e($booking->total_days > 1 ? 's' : ''); ?></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Locations -->
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500 mb-2">Pickup & Dropoff</h3>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div class="mb-3">
                                            <div class="text-sm text-gray-500">Pickup Location</div>
                                            <div class="font-medium"><?php echo e($booking->pickup_location); ?></div>
                                        </div>
                                        <div>
                                            <div class="text-sm text-gray-500">Dropoff Location</div>
                                            <div class="font-medium"><?php echo e($booking->dropoff_location); ?></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Driver Information -->
                                <?php if($booking->driver): ?>
                                <div class="md:col-span-2">
                                    <h3 class="text-sm font-medium text-gray-500 mb-2">Assigned Driver</h3>
                                    <div class="flex items-center p-4 border border-gray-200 rounded-lg">
                                        <div class="flex-shrink-0 h-16 w-16">
                                            <img class="h-16 w-16 rounded-full object-cover" src="<?php echo e($booking->driver && $booking->driver->driver_photo ? asset('storage/' . $booking->driver->driver_photo) : asset('images/driver-placeholder.jpg')); ?>" alt="<?php echo e($booking->driver ? $booking->driver->name : 'Driver'); ?>">
                                        </div>
                                        <div class="ml-4">
                                            <h3 class="text-lg font-medium text-gray-900"><?php echo e($booking->driver->name); ?></h3>
                                            <div class="text-sm text-gray-500">License: <?php echo e($booking->driver->license_number); ?></div>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                                
                                <!-- Special Requests -->
                                <?php if($booking->special_requests): ?>
                                <div class="md:col-span-2">
                                    <h3 class="text-sm font-medium text-gray-500 mb-2">Special Requests</h3>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <p class="text-gray-700"><?php echo e($booking->special_requests); ?></p>
                                    </div>
                                </div>
                                <?php endif; ?>
                                
                                <!-- Booking Timeline -->
                                <div class="md:col-span-2">
                                    <h3 class="text-sm font-medium text-gray-500 mb-2">Booking Timeline</h3>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div class="timeline">
                                            <div class="timeline-item">
                                                <div class="text-sm font-medium text-gray-900">Booking Created</div>
                                                <div class="text-sm text-gray-500"><?php echo e($booking->created_at->format('M d, Y h:i A')); ?></div>
                                            </div>
                                            <?php if($booking->status == 'confirmed'): ?>
                                            <div class="timeline-item">
                                                <div class="text-sm font-medium text-gray-900">Booking Confirmed</div>
                                                <div class="text-sm text-gray-500"><?php echo e($booking->updated_at->format('M d, Y h:i A')); ?></div>
                                            </div>
                                            <?php elseif($booking->status == 'cancelled'): ?>
                                            <div class="timeline-item">
                                                <div class="text-sm font-medium text-gray-900">Booking Cancelled</div>
                                                <div class="text-sm text-gray-500"><?php echo e($booking->updated_at->format('M d, Y h:i A')); ?></div>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Payment Summary -->
                    <div>
                        <div class="bg-white shadow rounded-xl p-6 sticky top-6">
                            <h2 class="text-lg font-medium text-gray-800 mb-4">Payment Summary</h2>
                            
                            <div class="space-y-4">
                                <div class="border-t border-gray-200 pt-4 mt-4">
                                    <div class="flex justify-between font-bold text-lg">
                                        <span>Total Amount:</span>
                                        <span>Rs. <?php echo e(number_format($booking->total_amount, 2)); ?></span>
                                    </div>
                                </div>
                                
                                <?php if($booking->status == 'confirmed'): ?>
                                <div class="pt-4 border-t border-gray-200">
                                    <h3 class="text-sm font-medium text-gray-700 mb-2">Payment Status</h3>
                                    <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                                        <div class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                            <span class="font-medium">20% Paid</span>
                                        </div>
                                        <span class="text-sm text-gray-600"><?php echo e($booking->updated_at->format('M d, Y')); ?></span>
                                    </div>
                                </div>
                                <?php elseif($booking->status == 'completed'): ?>
                                <div class="pt-4 border-t border-gray-200">
                                    <h3 class="text-sm font-medium text-gray-700 mb-2">Payment Status</h3>
                                    <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                                        <div class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                            <span class="font-medium">Fully Paid</span>
                                        </div>
                                        <span class="text-sm text-gray-600"><?php echo e($booking->updated_at->format('M d, Y')); ?></span>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        function confirmCancel(bookingId) {
            if (confirm('Are you sure you want to cancel this booking?')) {
                document.getElementById('cancel-booking-' + bookingId).submit();
            }
        }
    </script>
</body>
</html><?php /**PATH D:\fproject\project\project\sritravel\sritravel\resources\views/admin/bookings/show.blade.php ENDPATH**/ ?>