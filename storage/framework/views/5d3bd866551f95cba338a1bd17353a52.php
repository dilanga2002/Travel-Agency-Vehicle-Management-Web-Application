<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="<?php echo e(asset('images/favicon-32x32.png')); ?>">
    <title>SriTravel - Admin Dashboard</title>
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

        .card-icon {
            width: 3rem;
            height: 3rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .status-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .status-pending {
            background-color: #FEF3C7;
            color: #92400E;
        }

        .status-confirmed {
            background-color: #D1FAE5;
            color: #065F46;
        }

        .status-cancelled {
            background-color: #FEE2E2;
            color: #991B1B;
        }

        .status-completed {
            background-color: #E0E7FF;
            color: #3730A3;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }
            .main-content {
                margin-left: 200px;
                width: calc(100% - 200px);
            }
            .cards {
                grid-template-columns: repeat(2, 1fr);
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
            .cards {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">
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
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="text-white bg-blue-700 border-l-4 border-blue-400 flex items-center">
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
                        <a href="<?php echo e(route('admin.bookings.index')); ?>" class="text-blue-200 hover:text-white hover:bg-blue-700 flex items-center">
                            <i class="fas fa-calendar-check"></i> Bookings
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('admin.customers.index')); ?>" class="text-blue-200 hover:text-white hover:bg-blue-700 flex items-center">
                            <i class="fas fa-users"></i> Customers
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
                <h1 class="text-2xl font-semibold font-heading text-gray-800">Dashboard</h1>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600 hidden md:inline">Last login: <?php echo e(auth()->user()->last_login_at ? auth()->user()->last_login_at->diffForHumans() : 'First time login'); ?></span>
                    <div class="relative">
                        <button id="notificationBtn" class="p-1 text-gray-500 hover:text-blue-600">
                            <i class="fas fa-bell"></i>
                            <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500"></span>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Success Message -->
            <?php if(session('success')): ?>
                <div id="success-message" class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg" role="alert">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <!-- Main Content Area -->
            <main class="p-6 bg-white rounded-xl shadow">
                <!-- Cards -->
                <div class="cards grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    <div class="card bg-white rounded-lg p-5 shadow-md hover:shadow-lg transition-transform hover:-translate-y-1">
                        <div class="card-header flex justify-between items-center mb-4">
                            <h4 class="card-title text-sm text-gray-500">Total Vehicles</h4>
                            <div class="card-icon bg-blue-100 text-blue-600">
                                <i class="fas fa-car"></i>
                            </div>
                        </div>
                        <div class="card-value text-2xl font-semibold text-gray-800"><?php echo e($vehicleCount); ?></div>
                        <div class="card-footer text-xs text-gray-500"><?php echo e($vehiclePercentageChange); ?>% from last month</div>
                    </div>

                    <div class="card bg-white rounded-lg p-5 shadow-md hover:shadow-lg transition-transform hover:-translate-y-1">
                        <div class="card-header flex justify-between items-center mb-4">
                            <h4 class="card-title text-sm text-gray-500">Active Bookings</h4>
                            <div class="card-icon bg-green-100 text-green-600">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                        </div>
                        <div class="card-value text-2xl font-semibold text-gray-800"><?php echo e($bookingCount); ?></div>
                        <div class="card-footer text-xs text-gray-500"><?php echo e($bookingPercentageChange); ?>% from last month</div>
                    </div>

                    <div class="card bg-white rounded-lg p-5 shadow-md hover:shadow-lg transition-transform hover:-translate-y-1">
                        <div class="card-header flex justify-between items-center mb-4">
                            <h4 class="card-title text-sm text-gray-500">Available Drivers</h4>
                            <div class="card-icon bg-orange-100 text-orange-600">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="card-value text-2xl font-semibold text-gray-800"><?php echo e($driverCount); ?></div>
                        <div class="card-footer text-xs text-gray-500"><?php echo e($newDriversThisWeek); ?> new this week</div>
                    </div>
                </div>

                <!-- Recent Bookings Table -->
                <div class="content-area">
                    <div class="content-header flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                        <div class="mb-4 md:mb-0">
                            <h2 class="text-lg font-medium text-gray-800">Recent Bookings</h2>
                            <p class="text-sm text-gray-500">Latest customer bookings</p>
                        </div>
                        <a href="<?php echo e(route('admin.bookings.index')); ?>" class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200 hover:scale-105">
                            <i class="fas fa-eye mr-1"></i> View All
                        </a>
                    </div>

                    <?php if($recentBookings->isEmpty()): ?>
                        <div class="text-center py-12">
                            <i class="fas fa-calendar-times text-4xl text-gray-300 mb-3"></i>
                            <h3 class="text-lg font-medium text-gray-700">No bookings found</h3>
                            <p class="text-gray-500 mt-1">There are no recent bookings to display.</p>
                        </div>
                    <?php else: ?>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Booking ID</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vehicle</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dates</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php $__currentLoopData = $recentBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            Bk-<?php echo e($booking->id); ?>

                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-full" src="<?php echo e($booking->user->profile_photo ? asset('storage/'.$booking->user->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode($booking->user->name) . '&background=random'); ?>" alt="<?php echo e($booking->user->name); ?>">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900"><?php echo e($booking->user->name); ?></div>
                                                    <div class="text-sm text-gray-500"><?php echo e($booking->user->email); ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-md object-cover" src="<?php echo e($booking->vehicle->image ? asset('storage/'.$booking->vehicle->image) : asset('images/vehicle-placeholder.jpg')); ?>" alt="<?php echo e($booking->vehicle->make); ?> <?php echo e($booking->vehicle->model); ?>">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900"><?php echo e($booking->vehicle->make); ?> <?php echo e($booking->vehicle->model); ?></div>
                                                    <div class="text-sm text-gray-500"><?php echo e($booking->vehicle->registration_number); ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900"><?php echo e($booking->start_date->format('M d, Y')); ?></div>
                                            <div class="text-sm text-gray-500">to <?php echo e($booking->end_date->format('M d, Y')); ?></div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            Rs. <?php echo e(number_format($booking->total_amount, 2)); ?>

                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
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
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="<?php echo e(route('admin.bookings.show', $booking->id)); ?>" class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                <i class="fas fa-eye mr-1"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>

    <!-- Auto-hide success message -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const successMessage = document.getElementById('success-message');
            if (successMessage) {
                setTimeout(() => {
                    successMessage.style.transition = 'opacity 0.5s ease';
                    successMessage.style.opacity = '0';
                    setTimeout(() => {
                        successMessage.remove();
                    }, 500);
                }, 4500);
            }
        });
    </script>
</body>
</html><?php /**PATH C:\Users\User\Desktop\New folder\sritt\sritt\sritravel\sritravel\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>