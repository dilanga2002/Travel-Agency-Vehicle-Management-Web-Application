<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="<?php echo e(asset('images/favicon-32x32.png')); ?>">
    <title>SriTravel - Admin Booking Management</title>
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
                <h1 class="text-2xl font-semibold font-heading text-gray-800">Booking Management</h1>
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

            <?php if(session('success')): ?>
                <div id="success-message" class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg" role="alert">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <main class="p-6 bg-white rounded-xl shadow">
                <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="mb-4 md:mb-0">
                        <h2 class="text-lg font-medium text-gray-800">All Bookings</h2>
                        <p class="text-sm text-gray-500">Manage customer bookings</p>
                    </div>
                    <div class="flex space-x-2">
                        <div class="relative">
                            <select id="status-filter" class="appearance-none bg-white border border-gray-300 rounded-md pl-3 pr-8 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="all" <?php echo e(request('status') == 'all' || !request('status') ? 'selected' : ''); ?>>All Statuses</option>
                                <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                                <option value="confirmed" <?php echo e(request('status') == 'confirmed' ? 'selected' : ''); ?>>Confirmed</option>
                                <option value="cancelled" <?php echo e(request('status') == 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                                <option value="completed" <?php echo e(request('status') == 'completed' ? 'selected' : ''); ?>>Completed</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <i class="fas fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <?php if($bookings->isEmpty()): ?>
                        <div class="text-center py-12">
                            <i class="fas fa-calendar-times text-4xl text-gray-300 mb-3"></i>
                            <h3 class="text-lg font-medium text-gray-700">No bookings found</h3>
                            <p class="text-gray-500 mt-1">There are no bookings to display.</p>
                        </div>
                    <?php else: ?>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Booking ID</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vehicle</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dates</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                        <a href="<?php echo e(route('admin.bookings.show', $booking->id)); ?>" class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            <i class="fas fa-eye mr-1"></i> View
                                        </a>
                                        <?php if($booking->status == 'pending'): ?>
                                            <form action="<?php echo e(route('admin.bookings.confirm', $booking->id)); ?>" method="POST" class="inline">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                    <i class="fas fa-check mr-1"></i> Confirm
                                                </button>
                                            </form>
                                            <form action="<?php echo e(route('admin.bookings.cancel', $booking->id)); ?>" method="POST" class="inline">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                    <i class="fas fa-times mr-1"></i> Cancel
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        
                        <div class="mt-6">
                            <?php echo e($bookings->appends(request()->query())->links()); ?>

                        </div>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Status filter functionality
        document.getElementById('status-filter').addEventListener('change', function() {
            const status = this.value;
            const url = new URL(window.location.href);
            
            if (status === 'all') {
                url.searchParams.delete('status');
            } else {
                url.searchParams.set('status', status);
            }
            
            window.location.href = url.toString();
        });

        // Auto-hide success message
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
</html><?php /**PATH C:\Users\Dell\Desktop\sritravel\sritravel\resources\views/admin/bookings/index.blade.php ENDPATH**/ ?>