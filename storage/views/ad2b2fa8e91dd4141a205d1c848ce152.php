<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="<?php echo e(asset('images/favicon-32x32.png')); ?>">
    <title>SriTravel - My Dashboard</title>
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
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
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
                <p class="text-sm text-blue-200">Customer Panel</p>
            </div>
            
            <div class="p-4 border-b border-blue-800 flex items-center">
                <img class="h-10 w-10 rounded-full mr-3" src="<?php echo e(auth()->user()->profile_photo ? asset('storage/'.auth()->user()->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=random'); ?>" alt="User avatar">
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
                        <a href="<?php echo e(route('dashboard')); ?>" class="text-white bg-blue-700 border-l-4 border-blue-400 flex items-center">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('vehicles.index')); ?>" class="text-blue-200 hover:text-white hover:bg-blue-700 flex items-center">
                            <i class="fas fa-car"></i> Browse Vehicles
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('bookings.index')); ?>" class="text-blue-200 hover:text-white hover:bg-blue-700 flex items-center">
                            <i class="fas fa-calendar-check"></i> My Bookings
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('profile.show')); ?>" class="text-blue-200 hover:text-white hover:bg-blue-700 flex items-center">
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
            <!-- Header -->
            <header class="bg-white shadow-md rounded-lg p-4 flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold font-heading text-gray-800">Dashboard Overview</h2>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600 hidden md:inline">Last login: <?php echo e(auth()->user()->last_login_at?->diffForHumans() ?? 'First time login'); ?></span>
                    <div class="relative">
                        <button id="notificationBtn" class="p-1 text-gray-500 hover:text-blue-600">
                            <i class="fas fa-bell"></i>
                            <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500"></span>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-6">
                <!-- Welcome Banner -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-xl p-6 mb-6 shadow-md transition duration-300 hover:scale-105">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-car text-4xl opacity-20"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-2xl font-bold">Welcome back, <?php echo e(auth()->user()->name); ?>!</h3>
                            <p class="mt-1 text-blue-100">You have <?php echo e($activeBookingsCount); ?> active bookings</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="dashboard-card bg-white shadow rounded-xl p-6 transition duration-300 hover:scale-105">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Active Bookings</p>
                                <p class="text-2xl font-semibold text-gray-900"><?php echo e($activeBookingsCount); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="dashboard-card bg-white shadow rounded-xl p-6 transition duration-300 hover:scale-105">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-gray-100 text-gray-600 mr-4">
                                <i class="fas fa-list"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Total Bookings</p>
                                <p class="text-2xl font-semibold text-gray-900"><?php echo e($totalBookingsCount); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="dashboard-card bg-white shadow rounded-xl p-6 transition duration-300 hover:scale-105">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                                <i class="fas fa-check-double"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Completed Bookings</p>
                                <p class="text-2xl font-semibold text-gray-900"><?php echo e($completedBookingsCount); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Current Bookings -->
                <div class="bg-white shadow rounded-xl p-6 mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-800">Current Bookings</h3>
                        <a href="<?php echo e(route('bookings.index')); ?>" class="text-sm text-blue-600 hover:text-blue-800 flex items-center">
                            View All <i class="fas fa-chevron-right ml-1 text-xs"></i>
                        </a>
                    </div>
                    
                    <?php if($currentBookings->isEmpty()): ?>
                        <div class="text-center py-8">
                            <i class="fas fa-calendar-times text-4xl text-gray-300 mb-3"></i>
                            <p class="text-gray-500">You don't have any upcoming bookings</p>
                            <a href="<?php echo e(route('vehicles.index')); ?>" class="mt-3 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring focus:ring-blue-200 disabled:opacity-25 transition">
                                <i class="fas fa-car mr-2"></i> Book a Vehicle Now
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="space-y-4">
                            <?php $__currentLoopData = $currentBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition">
                                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                    <div class="flex items-start space-x-4 flex-1">
                                        <div class="flex-shrink-0">
                                            <img class="h-16 w-16 rounded-md object-cover" src="<?php echo e($booking->vehicle->image ? asset('storage/'.$booking->vehicle->image) : asset('images/vehicle-placeholder.jpg')); ?>" alt="">
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-gray-900"><?php echo e($booking->vehicle->make); ?> <?php echo e($booking->vehicle->model); ?></h4>
                                            <div class="mt-1">
                                                <?php if($booking->status == 'confirmed'): ?>
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        Confirmed
                                                    </span>
                                                <?php elseif($booking->status == 'pending'): ?>
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        Pending
                                                    </span>
                                                <?php else: ?>
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                        Cancelled
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="text-sm text-gray-900 mt-1">
                                                <i class="fas fa-calendar-day text-blue-500 mr-1"></i> 
                                                <?php echo e($booking->start_date->format('M d, Y')); ?> - <?php echo e($booking->end_date->format('M d, Y')); ?>

                                            </div>
                                            <div class="text-sm font-semibold text-gray-900 mt-1">
                                                Rs. <?php echo e(number_format($booking->total_amount, 2)); ?>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4 md:mt-0 md:flex md:items-center md:justify-end md:space-x-2">
                                        <a href="<?php echo e(route('bookings.show', $booking->id)); ?>" class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            <i class="fas fa-eye mr-1"></i> View
                                        </a>
                                        <?php if($booking->status == 'pending'): ?>
                                            <button onclick="confirmCancel('<?php echo e($booking->id); ?>')" class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                <i class="fas fa-times mr-1"></i> Cancel
                                            </button>
                                            <form id="cancel-booking-<?php echo e($booking->id); ?>" action="<?php echo e(route('bookings.cancel', $booking->id)); ?>" method="POST" class="hidden">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Recommended Vehicles -->
                <div class="bg-white shadow rounded-xl p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-800">Recommended For You</h3>
                        <a href="<?php echo e(route('vehicles.index')); ?>" class="text-sm text-blue-600 hover:text-blue-800 flex items-center">
                            Browse All <i class="fas fa-chevron-right ml-1 text-xs"></i>
                        </a>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php $__currentLoopData = $recommendedVehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="vehicle-card bg-white border border-gray-200 rounded-lg overflow-hidden transition duration-300 hover:scale-105 shadow-sm">
                            <div class="relative h-48">
                                <img class="absolute h-full w-full object-cover" src="<?php echo e($vehicle->image ? asset('storage/'.$vehicle->image) : asset('images/vehicle-placeholder.jpg')); ?>" alt="<?php echo e($vehicle->make); ?> <?php echo e($vehicle->model); ?>">
                                <div class="absolute top-2 right-2 bg-blue-600 text-white text-xs px-2 py-1 rounded-full">
                                    <?php echo e(ucfirst($vehicle->type)); ?>

                                </div>
                            </div>
                            <div class="p-4">
                                <h4 class="font-bold text-lg text-gray-900"><?php echo e($vehicle->make); ?> <?php echo e($vehicle->model); ?></h4>
                                <div class="flex items-center text-gray-600 text-sm mt-1">
                                    <span class="mr-2"><?php echo e($vehicle->passengers); ?> passengers</span>
                                    <?php if(!empty($vehicle->features)): ?>
                                        <span class="mr-2">•</span>
                                        <span><?php echo e(implode(' • ', $vehicle->features)); ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="mt-3">
                                    <span class="text-xl font-bold text-blue-600">Rs. <?php echo e(number_format($vehicle->price_per_km, 2)); ?></span>
                                    <span class="text-gray-500 text-sm"> / 1km</span>
                                </div>
                                <div class="mt-4">
                                    <a href="<?php echo e(route('vehicles.show', $vehicle->id)); ?>" class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md transition duration-300 hover:scale-105">
                                        <i class="fas fa-calendar-check mr-2"></i> Book Now
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
</html><?php /**PATH D:\fproject\project\project\sritravel\sritravel\resources\views/dashboard.blade.php ENDPATH**/ ?>