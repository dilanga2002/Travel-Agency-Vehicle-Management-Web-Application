<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="<?php echo e(asset('images/favicon-32x32.png')); ?>">
    <title>SriTravel - Admin Vehicle Management</title>
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

        .status-available {
            background-color: #D1FAE5;
            color: #065F46;
        }

        .status-unavailable {
            background-color: #FEE2E2;
            color: #991B1B;
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
                        <a href="/" class="<?php echo e(request()->routeIs('/') ? 'text-white bg-blue-700 border-l-4 border-blue-400' : 'text-blue-200 hover:text-white hover:bg-blue-700'); ?> flex items-center">
                            <i class="fas fa-home"></i> Home
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="<?php echo e(request()->routeIs('admin.dashboard') ? 'text-white bg-blue-700 border-l-4 border-blue-400' : 'text-blue-200 hover:text-white hover:bg-blue-700'); ?> flex items-center">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('admin.vehicles.index')); ?>" class="<?php echo e(request()->routeIs('admin.vehicles.index') ? 'text-white bg-blue-700 border-l-4 border-blue-400' : 'text-blue-200 hover:text-white hover:bg-blue-700'); ?> flex items-center">
                            <i class="fas fa-car"></i> Vehicles
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('admin.drivers.index')); ?>" class="<?php echo e(request()->routeIs('admin.drivers.index') ? 'text-white bg-blue-700 border-l-4 border-blue-400' : 'text-blue-200 hover:text-white hover:bg-blue-700'); ?> flex items-center">
                            <i class="fas fa-users"></i> Drivers
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('admin.bookings.index')); ?>" class="<?php echo e(request()->routeIs('admin.bookings.index') ? 'text-white bg-blue-700 border-l-4 border-blue-400' : 'text-blue-200 hover:text-white hover:bg-blue-700'); ?> flex items-center">
                            <i class="fas fa-calendar-check"></i> Bookings
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('admin.customers.index')); ?>" class="text-blue-200 hover:text-white hover:bg-blue-700 flex items-center">
                            <i class="fas fa-users"></i> Customers
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('admin.reports.index')); ?>" class="<?php echo e(request()->routeIs('admin.reports.index') ? 'text-white bg-blue-700 border-l-4 border-blue-400' : 'text-blue-200 hover:text-white hover:bg-blue-700'); ?> flex items-center">
                            <i class="fas fa-chart-bar"></i> Reports
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('admin.profile.show')); ?>" class="<?php echo e(request()->routeIs('admin.profile.show') ? 'text-white bg-blue-700 border-l-4 border-blue-400' : 'text-blue-200 hover:text-white hover:bg-blue-700'); ?> flex items-center">
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
            <header class="bg-white shadow-sm rounded-lg p-4 flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold font-heading text-gray-800">Vehicle Management</h1>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600 hidden md:inline">Last login: <?php echo e(auth()->user()->last_login_at?->diffForHumans() ?? 'First time login'); ?></span>
                    <div class="relative">
                        <button id="notificationBtn" class="p-1 text-gray-600 hover:text-blue-600">
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

            <!-- Page Content -->
            <main class="p-4 bg-white rounded-lg shadow-sm">
                <div class="mb-4 flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="mb-4 md:mb-0">
                        <h2 class="text-lg font-medium text-gray-800">All Vehicles</h2>
                        <p class="text-sm text-gray-600">Manage your vehicle fleet</p>
                    </div>
                    <div class="flex space-x-2">
                        <a href="<?php echo e(route('admin.vehicles.create')); ?>" class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 transition duration-200 hover:scale-105">
                            <i class="fas fa-plus mr-1"></i> Add New Vehicle
                        </a>
                    </div>
                </div>

                <!-- Vehicle Grid -->
                <?php if($vehicles->isEmpty()): ?>
                    <div class="text-center py-12">
                        <i class="fas fa-car text-4xl text-gray-300 mb-3"></i>
                        <h3 class="text-lg font-medium text-gray-700">No vehicles found</h3>
                        <p class="text-gray-600 mt-1">There are no vehicles to display.</p>
                    </div>
                <?php else: ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300 bg-white p-4">
                            <div class="relative">
                                <img src="<?php echo e($vehicle->image ? asset('storage/'.$vehicle->image) : asset('images/vehicle-placeholder.jpg')); ?>" 
                                     alt="<?php echo e($vehicle->make); ?> <?php echo e($vehicle->model); ?>" 
                                     class="w-full h-32 object-cover rounded-lg">
                                <span class="status-badge absolute top-2 right-2 
                                    <?php echo e($vehicle->available ? 'status-available' : 'status-unavailable'); ?>">
                                    <?php echo e($vehicle->available ? 'Available' : 'Not Available'); ?>

                                </span>
                            </div>
                            <div class="p-4">
                                <h4 class="font-bold text-lg text-gray-800"><?php echo e($vehicle->make); ?> <?php echo e($vehicle->model); ?></h4>
                                <div class="flex justify-between mt-2">
                                    <span class="text-sm text-gray-600"><?php echo e($vehicle->year); ?></span>
                                    <span class="text-sm font-semibold text-gray-700">LKR <?php echo e(number_format($vehicle->price_per_km, 2)); ?>/km</span>
                                </div>
                                <div class="mt-2 text-sm text-gray-600 flex items-center flex-wrap">
                                    <span class="flex items-center">
                                        <i class="fas fa-users mr-1 text-blue-600"></i>
                                        <?php echo e($vehicle->passengers); ?> passengers
                                    </span>
                                    <?php if(!empty($vehicle->features)): ?>
                                        <?php $__currentLoopData = $vehicle->features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="flex items-center">
                                                <span class="mx-2 text-gray-400">•</span>
                                                <?php if(str_contains(strtolower($feature), 'air conditioning')): ?>
                                                    <i class="fas fa-snowflake mr-1 text-blue-600"></i>
                                                <?php elseif(str_contains(strtolower($feature), 'usb charging')): ?>
                                                    <i class="fas fa-usb mr-1 text-blue-600"></i>
                                                <?php elseif(str_contains(strtolower($feature), 'gps')): ?>
                                                    <i class="fas fa-map-marker-alt mr-1 text-blue-600"></i>
                                                <?php elseif(str_contains(strtolower($feature), 'wi-fi')): ?>
                                                    <i class="fas fa-wifi mr-1 text-blue-600"></i>
                                                <?php elseif(str_contains(strtolower($feature), 'bluetooth')): ?>
                                                    <i class="fas fa-bluetooth-b mr-1 text-blue-600"></i>
                                                <?php elseif(str_contains(strtolower($feature), 'leather seats')): ?>
                                                    <i class="fas fa-chair mr-1 text-blue-600"></i>
                                                <?php elseif(str_contains(strtolower($feature), 'sunroof')): ?>
                                                    <i class="fas fa-sun mr-1 text-blue-600"></i>
                                                <?php elseif(str_contains(strtolower($feature), 'child seat')): ?>
                                                    <i class="fas fa-baby-carriage mr-1 text-blue-600"></i>
                                                <?php else: ?>
                                                    <i class="fas fa-check-circle mr-1 text-blue-600"></i>
                                                <?php endif; ?>
                                                <?php echo e($feature); ?>

                                            </span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </div>
                                <div class="mt-3 flex justify-between items-center">
                                    <span class="text-sm text-gray-600"><?php echo e($vehicle->registration_number); ?></span>
                                    <div class="flex space-x-2">
                                        <a href="<?php echo e(route('admin.vehicles.edit', $vehicle->id)); ?>" 
                                           class="inline-flex items-center px-2 py-1 border border-transparent text-xs font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 transition duration-200 hover:scale-105">
                                            <i class="fas fa-edit mr-1 text-xs"></i> Edit
                                        </a>
                                        <form action="<?php echo e(route('admin.vehicles.destroy', $vehicle->id)); ?>" method="POST" class="inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" 
                                                    class="inline-flex items-center px-2 py-1 border border-transparent text-xs font-medium rounded-lg shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-600 transition duration-200 hover:scale-105" 
                                                    onclick="return confirm('Are you sure you want to delete this vehicle?')">
                                                <i class="fas fa-trash mr-1 text-xs"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        <?php echo e($vehicles->links()); ?>

                    </div>
                <?php endif; ?>
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
</html><?php /**PATH C:\Users\Dell\Desktop\sritravel\sritravel\resources\views/admin/vehicles/index.blade.php ENDPATH**/ ?>