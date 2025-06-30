<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Assignment Details | SriTravel</title>
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

        .status-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
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
                <p class="text-sm text-blue-200">Driver Panel</p>
            </div>
            
            <div class="p-4 border-b border-blue-800 flex items-center">
                <img class="h-10 w-10 rounded-full mr-3" src="<?php echo e(auth()->user()->profile_photo ? asset('storage/'.auth()->user()->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=random'); ?>" alt="Driver photo">
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
                        <a href="<?php echo e(route('driver.dashboard')); ?>" class="text-blue-200 hover:text-white hover:bg-blue-700 flex items-center">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('driver.bookings.index')); ?>" class="text-white bg-blue-700 border-l-4 border-blue-400 flex items-center">
                            <i class="fas fa-calendar-check"></i> My Assignments
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('driver.profile.edit')); ?>" class="text-blue-200 hover:text-white hover:bg-blue-700 flex items-center">
                            <i class="fas fa-user"></i> My Profile
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
            <header class="bg-white shadow-md rounded-lg p-4 mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800 font-heading">Assignment Bk-<?php echo e($booking->id); ?></h1>
                        <nav class="flex" aria-label="Breadcrumb">
                            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                                <li class="inline-flex items-center">
                                    <a href="<?php echo e(route('driver.dashboard')); ?>" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                                        <i class="fas fa-home mr-2"></i>
                                        Dashboard
                                    </a>
                                </li>
                                <li>
                                    <div class="flex items-center">
                                        <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                                        <a href="<?php echo e(route('driver.bookings.index')); ?>" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">My Assignments</a>
                                    </div>
                                </li>
                                <li aria-current="page">
                                    <div class="flex items-center">
                                        <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Details</span>
                                    </div>
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <div class="flex items-center space-x-2">
                        <?php if($booking->status == 'confirmed'): ?>
                            <button onclick="markAsCompleted(<?php echo e($booking->id); ?>)" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:border-green-800 focus:ring focus:ring-green-200 disabled:opacity-25 transition">
                                <i class="fas fa-check-circle mr-2"></i> Mark as Completed
                            </button>
                        <?php endif; ?>
                        <a href="<?php echo e(route('driver.bookings.index')); ?>" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-200 active:bg-gray-300 focus:outline-none focus:border-gray-300 focus:ring focus:ring-gray-200 disabled:opacity-25 transition">
                            <i class="fas fa-arrow-left mr-2"></i> Back
                        </a>
                    </div>
                </div>
            </header>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Assignment Details -->
                <div class="lg:col-span-2">
                    <div class="bg-white shadow rounded-xl p-6 mb-6">
                        <div class="flex justify-between items-start mb-6">
                            <h2 class="text-lg font-medium text-gray-800 font-heading">Assignment Information</h2>
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
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 mb-2">Customer Details</h3>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="flex items-center mb-3">
                                        <div class="flex-shrink-0 h-12 w-12">
                                            <img class="h-12 w-12 rounded-full" 
                                                 src="<?php echo e($booking->user->profile_photo ? asset('storage/' . $booking->user->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode($booking->user->name) . '&background=random'); ?>" 
                                                 alt="Customer photo">
                                        </div>
                                        <div class="ml-3">
                                            <h4 class="font-medium text-gray-800"><?php echo e($booking->user->name); ?></h4>
                                            <p class="text-sm text-gray-500"><?php echo e($booking->user->email); ?></p>
                                        </div>
                                    </div>
                                    <div class="space-y-2">
                                        <div class="flex items-center text-sm text-gray-600">
                                            <i class="fas fa-phone-alt mr-2 text-gray-400"></i>
                                            <span><?php echo e($booking->user->phone); ?></span>
                                        </div>
                                        <div class="flex items-center text-sm text-gray-600">
                                            <i class="fas fa-map-marker-alt mr-2 text-gray-400"></i>
                                            <span><?php echo e($booking->user->address); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Vehicle Information -->
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 mb-2">Vehicle Details</h3>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="flex items-center mb-3">
                                        <div class="flex-shrink-0 h-12 w-12">
                                            <img class="h-12 w-12 rounded-md object-cover" src="<?php echo e($booking->vehicle->image ? asset('storage/'.$booking->vehicle->image) : 'https://ui-avatars.com/api/?name=' . urlencode($booking->vehicle->make . ' ' . $booking->vehicle->model) . '&background=random'); ?>" alt="">
                                        </div>
                                        <div class="ml-3">
                                            <h4 class="font-medium text-gray-800"><?php echo e($booking->vehicle->make); ?> <?php echo e($booking->vehicle->model); ?></h4>
                                            <p class="text-sm text-gray-500"><?php echo e($booking->vehicle->registration_number); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Trip Details -->
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 mb-2">Trip Dates</h3>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="flex items-center justify-between mb-2">
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
                            
                            <!-- Special Requests -->
                            <?php if($booking->special_requests): ?>
                            <div class="md:col-span-2">
                                <h3 class="text-sm font-medium text-gray-500 mb-2">Special Requests</h3>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="text-gray-700"><?php echo e($booking->special_requests); ?></p>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <!-- Assignment Timeline -->
                            <div class="md:col-span-2">
                                <h3 class="text-sm font-medium text-gray-500 mb-2">Assignment Timeline</h3>
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
                                        <div class="timeline-item">
                                            <div class="text-sm font-medium text-gray-900">Assigned to You</div>
                                            <div class="text-sm text-gray-500"><?php echo e($booking->updated_at->format('M d, Y h:i A')); ?></div>
                                        </div>
                                        <?php elseif($booking->status == 'cancelled'): ?>
                                        <div class="timeline-item">
                                            <div class="text-sm font-medium text-gray-900">Booking Cancelled</div>
                                            <div class="text-sm text-gray-500"><?php echo e($booking->updated_at->format('M d, Y h:i A')); ?></div>
                                        </div>
                                        <?php elseif($booking->status == 'completed'): ?>
                                        <div class="timeline-item">
                                            <div class="text-sm font-medium text-gray-900">Trip Completed</div>
                                            <div class="text-sm text-gray-500"><?php echo e($booking->updated_at->format('M d, Y h:i A')); ?></div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function markAsCompleted(bookingId) {
            if (confirm('Are you sure you want to mark this trip as completed?')) {
                console.log('Marking booking ' + bookingId + ' as completed');
                alert('Trip marked as completed!');
                window.location.reload();
            }
        }
    </script>
</body>
</html><?php /**PATH D:\fproject\project\project\sritravel\sritravel\resources\views/driver/bookings/show.blade.php ENDPATH**/ ?>