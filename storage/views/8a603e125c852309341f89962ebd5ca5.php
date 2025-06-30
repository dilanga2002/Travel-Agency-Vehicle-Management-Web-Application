<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="<?php echo e(asset('images/favicon-32x32.png')); ?>">
    <title>SriTravel - Available Vehicles</title>
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
                    animation: {
                        'fade-in': 'fadeIn 1s ease-in-out',
                        'slide-up': 'slideUp 0.8s ease-out',
                        'slide-right': 'slideRight 0.8s ease-out',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(50px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        slideRight: {
                            '0%': { transform: 'translateX(-50px)', opacity: '0' },
                            '100%': { transform: 'translateX(0)', opacity: '1' },
                        }
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #3B82F6;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #2563EB;
        }

        /* Animation classes */
        .animate-on-scroll {
            opacity: 0;
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }
        .animate-on-scroll.animated {
            opacity: 1;
        }
        .slide-up {
            transform: translateY(50px);
        }
        .slide-up.animated {
            transform: translateY(0);
        }
        .slide-right {
            transform: translateX(-50px);
        }
        .slide-right.animated {
            transform: translateX(0);
        }
        .fade-in {
            opacity: 0;
        }
        .fade-in.animated {
            opacity: 1;
        }

        /* Dashboard-specific styles */
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

        /* Vehicle card styles */
        .vehicle-card {
            transition: all 0.3s;
        }
        .vehicle-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        .type-filter:checked + label {
            background-color: #2563EB;
            color: white;
            border-color: #1E40AF;
        }
        .hover-scale {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .hover-scale:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        /* Date input styles */
        .date-input-error {
            border-color: #EF4444 !important;
        }
        .date-error-message {
            color: #EF4444;
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body class="font-sans bg-gray-50">
    <?php if(auth()->guard()->check()): ?>
    <!-- Authenticated User: Dashboard Layout with Sidebar -->
    <div class="dashboard-container">
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
                        <a href="<?php echo e(route('dashboard')); ?>" class="text-blue-200 hover:text-white hover:bg-blue-700 flex items-center">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('vehicles.index')); ?>" class="text-white bg-blue-700 border-l-4 border-blue-400 flex items-center">
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

        <div class="main-content">
    <?php else: ?>
    <!-- Non-Authenticated User: Public Layout with Navbar -->
    <nav class="bg-white text-gray-800 py-4 shadow-sm fixed top-0 w-full z-50">
        <div class="container mx-auto px-6 flex justify-between items-center">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="/" class="text-2xl font-bold font-heading flex items-center">
                    <i class="fas fa-car text-blue-500 mr-2"></i>
                    <span class="text-blue-500">Sri</span><span class="text-gray-800">Travel</span>
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden lg:flex items-center space-x-8">
                <a href="/" class="text-gray-600 hover:text-blue-600 font-medium flex items-center transition duration-200">
                    <i class="fas fa-home mr-2"></i> Home
                </a>
                <a href="/vehicles" class="text-blue-600 font-medium flex items-center transition duration-200">
                    <i class="fas fa-car mr-2"></i> Vehicles
                </a>
                <a href="/about" class="text-gray-600 hover:text-blue-600 font-medium flex items-center transition duration-200">
                    <i class="fas fa-info-circle mr-2"></i> About
                </a>
                <a href="/contact" class="text-gray-600 hover:text-blue-600 font-medium flex items-center transition duration-200">
                    <i class="fas fa-phone-alt mr-2"></i> Contact
                </a>
            </div>

            <!-- Desktop Auth Buttons -->
            <div class="hidden lg:flex space-x-4">
                <a href="<?php echo e(route('login')); ?>"
                   class="px-5 py-2 border border-blue-500 text-blue-600 font-medium rounded-full hover:bg-blue-50 flex items-center">
                    <i class="fas fa-sign-in-alt mr-2"></i> Sign In
                </a>
                <a href="<?php echo e(route('register')); ?>"
                   class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-full flex items-center">
                    <i class="fas fa-user-plus mr-2"></i> Sign Up
                </a>
            </div>

            <!-- Mobile menu button -->
            <button class="lg:hidden text-gray-800 focus:outline-none" id="mobile-menu-button">
                <i class="fas fa-bars text-2xl"></i>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div class="lg:hidden hidden bg-white absolute top-full left-0 right-0 py-4 px-6 shadow-lg" id="mobile-menu">
            <div class="flex flex-col space-y-4">
                <a href="/" class="text-blue-600 font-medium">
                    <i class="fas fa-home mr-2"></i> Home
                </a>
                <a href="/vehicles" class="text-gray-600 hover:text-blue-600 font-medium">
                    <i class="fas fa-car mr-2"></i> Vehicles
                </a>
                <a href="/about" class="text-gray-600 hover:text-blue-600 font-medium">
                    <i class="fas fa-info-circle mr-2"></i> About
                </a>
                <a href="/contact" class="text-gray-600 hover:text-blue-600 font-medium">
                    <i class="fas fa-phone-alt mr-2"></i> Contact
                </a>

                <div class="pt-2 border-t border-gray-200">
                    <a href="<?php echo e(route('login')); ?>"
                       class="block text-center border border-blue-500 text-blue-600 font-medium rounded-full py-2 mb-2">
                        <i class="fas fa-sign-in-alt mr-2"></i> Sign In
                    </a>
                    <a href="<?php echo e(route('register')); ?>"
                       class="block text-center bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-full py-2">
                        <i class="fas fa-user-plus mr-2"></i> Sign Up
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <div class="pt-20">
    <?php endif; ?>

            <header class="bg-white shadow-md rounded-lg p-4 flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-semibold font-heading text-gray-800">Available Vehicles</h1>
                    <p class="text-sm text-gray-500 mt-1">Browse and book from our wide selection of vehicles</p>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600 hidden md:inline"><?php echo e($vehicles->total()); ?> vehicles available</span>
                    <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('bookings.index')); ?>" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring focus:ring-blue-200 transition">
                        <i class="fas fa-calendar-check mr-2"></i> My Bookings
                    </a>
                    <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring focus:ring-blue-200 transition">
                        <i class="fas fa-sign-in-alt mr-2"></i> Sign In to Book
                    </a>
                    <?php endif; ?>
                </div>
            </header>

            <main>
                <div class="container mx-auto px-6">
                    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                        <div class="lg:col-span-1">
                            <div class="bg-white shadow rounded-xl p-6">
                                <h2 class="text-lg font-semibold text-gray-800 mb-4">Filter Vehicles</h2>
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Vehicle Type</label>
                                    <div class="space-y-2">
                                        <input type="checkbox" id="type-all" class="type-filter hidden" checked>
                                        <label for="type-all" class="inline-flex items-center px-3 py-2 rounded-full border border-gray-300 bg-white text-sm font-medium text-gray-700 cursor-pointer hover:bg-gray-50">
                                            All Types
                                        </label>
                                        <input type="checkbox" id="type-car" class="type-filter hidden">
                                        <label for="type-car" class="inline-flex items-center px-3 py-2 rounded-full border border-gray-300 bg-white text-sm font-medium text-gray-700 cursor-pointer hover:bg-gray-50">
                                            <i class="fas fa-car mr-1"></i> Car
                                        </label>
                                        <input type="checkbox" id="type-cab" class="type-filter hidden">
                                        <label for="type-cab" class="inline-flex items-center px-3 py-2 rounded-full border border-gray-300 bg-white text-sm font-medium text-gray-700 cursor-pointer hover:bg-gray-50">
                                            <i class="fas fa-taxi mr-1"></i> Cab
                                        </label>
                                        <input type="checkbox" id="type-van" class="type-filter hidden">
                                        <label for="type-van" class="inline-flex items-center px-3 py-2 rounded-full border border-gray-300 bg-white text-sm font-medium text-gray-700 cursor-pointer hover:bg-gray-50">
                                            <i class="fas fa-van-shuttle mr-1"></i> Van
                                        </label>
                                        <input type="checkbox" id="type-minibus" class="type-filter hidden">
                                        <label for="type-minibus" class="inline-flex items-center px-3 py-2 rounded-full border border-gray-300 bg-white text-sm font-medium text-gray-700 cursor-pointer hover:bg-gray-50">
                                            <i class="fas fa-shuttle-van mr-1"></i> Minibus
                                        </label>
                                        <input type="checkbox" id="type-bus" class="type-filter hidden">
                                        <label for="type-bus" class="inline-flex items-center px-3 py-2 rounded-full border border-gray-300 bg-white text-sm font-medium text-gray-700 cursor-pointer hover:bg-gray-50">
                                            <i class="fas fa-bus mr-1"></i> Bus
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Price Range (per 1km)</label>
                                    <div class="flex items-center justify-between space-x-4">
                                        <input type="number" id="min-price" placeholder="Min" 
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        <span class="text-gray-500">to</span>
                                        <input type="number" id="max-price" placeholder="Max" 
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    </div>
                                    <div id="price-error" class="date-error-message hidden">Minimum price cannot exceed maximum price</div>
                                </div>
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Date Range</label>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label for="start-date" class="block text-xs font-medium text-gray-600 mb-1">Start Date</label>
                                            <input type="date" id="start-date" 
                                                   min="<?php echo e(\Carbon\Carbon::today()->format('Y-m-d')); ?>"
                                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 p-2">
                                            <div id="start-date-error" class="date-error-message hidden">Please select a future date</div>
                                        </div>
                                        <div>
                                            <label for="end-date" class="block text-xs font-medium text-gray-600 mb-1">End Date</label>
                                            <input type="date" id="end-date" 
                                                   min="<?php echo e(\Carbon\Carbon::today()->format('Y-m-d')); ?>"
                                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 p-2">
                                            <div id="end-date-error" class="date-error-message hidden">End date must be after start date</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-6 pt-4 border-t border-gray-200">
                                    <button type="button" id="apply-filters" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Apply Filters
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="lg:col-span-3">
                            <?php if($vehicles->isEmpty()): ?>
                                <div class="bg-white shadow rounded-xl p-6 text-center">
                                    <i class="fas fa-car-side text-4xl text-gray-300 mb-3"></i>
                                    <h3 class="text-lg font-semibold text-gray-700">No Vehicles Available</h3>
                                    <p class="text-gray-500 mt-1">Please check back later or adjust your filters.</p>
                                </div>
                            <?php else: ?>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                    <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="vehicle-card bg-white shadow rounded-xl overflow-hidden">
                                        <div class="relative h-48">
                                            <img class="absolute h-full w-full object-cover" src="<?php echo e($vehicle->image ? asset('storage/'.$vehicle->image) : asset('images/default-vehicle.jpg')); ?>" alt="<?php echo e($vehicle->make); ?> <?php echo e($vehicle->model); ?>">
                                            <div class="absolute top-2 right-2 bg-blue-600 text-white text-xs px-2 py-1 rounded-full">
                                                <?php echo e(ucfirst($vehicle->type)); ?>

                                            </div>
                                        </div>
                                        <div class="p-4">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <h3 class="font-bold text-lg text-gray-900"><?php echo e($vehicle->make); ?> <?php echo e($vehicle->model); ?></h3>
                                                    <div class="flex items-center text-gray-600 text-sm mt-1">
                                                        <span class="mr-2"><i class="fas fa-users mr-1 text-gray-400"></i><?php echo e($vehicle->passengers); ?> passengers</span>
                                                        <?php if(!empty($vehicle->features)): ?>
                                                            <span class="mr-2">•</span>
                                                            <span><?php echo e(implode(' • ', $vehicle->features)); ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <div class="text-xl font-bold text-blue-600">Rs. <?php echo e(number_format($vehicle->price_per_km, 2)); ?></div>
                                                    <div class="text-gray-500 text-sm">per 1km</div>
                                                </div>
                                            </div>
                                            
                                            <div class="mt-4">
                                                <a href="<?php echo e(auth()->check() ? route('bookings.create', ['vehicle_id' => $vehicle->id, 'price_per_km' => $vehicle->price_per_km]) : route('login')); ?>" class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition duration-300 hover:scale-105">
                                                    <i class="fas fa-calendar-check mr-2"></i> <?php echo e(auth()->check() ? 'Book Now' : 'Sign In to Book'); ?>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                                
                                <div class="mt-6">
                                    <?php echo e($vehicles->links()); ?>

                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </main>
    <?php if(auth()->guard()->check()): ?>
        </div>
    </div>
    <?php else: ?>
        </div>
        <!-- Footer for Non-Authenticated Users -->
        <footer class="bg-gray-800 text-white pt-16 pb-8">
            <div class="container mx-auto px-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                    <!-- About -->
                    <div class="animate-on-scroll slide-up">
                        <h3 class="text-xl font-bold font-heading mb-6 flex items-center">
                            <i class="fas fa-car text-blue-400 mr-2"></i>
                            <span class="text-blue-400">Sri</span><span>Travel</span>
                        </h3>
                        <p class="text-gray-300 mb-4">
                            SriTravel is the premier vehicle rental service in Sri Lanka, offering premium vehicles with professional drivers for tourists and business travelers.
                        </p>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-300 hover:text-blue-400 text-xl">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="text-gray-300 hover:text-blue-400 text-xl">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="text-gray-300 hover:text-blue-400 text-xl">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="text-gray-300 hover:text-blue-400 text-xl">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="animate-on-scroll slide-up" style="transition-delay: 0.1s">
                        <h3 class="text-lg font-bold font-heading mb-6">Quick Links</h3>
                        <ul class="space-y-3">
                            <li><a href="/" class="text-gray-300 hover:text-blue-400 transition duration-200"><i class="fas fa-chevron-right text-xs mr-2"></i> Home</a></li>
                            <li><a href="/vehicles" class="text-gray-300 hover:text-blue-400 transition duration-200"><i class="fas fa-chevron-right text-xs mr-2"></i> Vehicles</a></li>
                            <li><a href="/about" class="text-gray-300 hover:text-blue-400 transition duration-200"><i class="fas fa-chevron-right text-xs mr-2"></i> About Us</a></li>
                            <li><a href="/contact" class="text-gray-300 hover:text-blue-400 transition duration-200"><i class="fas fa-chevron-right text-xs mr-2"></i> Contact</a></li>
                        </ul>
                    </div>

                    <!-- Contact Info -->
                    <div class="animate-on-scroll slide-up" style="transition-delay: 0.2s">
                        <h3 class="text-lg font-bold font-heading mb-6">Contact Us</h3>
                        <ul class="space-y-4">
                            <li class="flex items-start">
                                <i class="fas fa-map-marker-alt text-blue-400 mt-1 mr-4"></i>
                                <span class="text-gray-300">123 Galle Road, Colombo 03, Sri Lanka</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-phone-alt text-blue-400 mr-4"></i>
                                <span class="text-gray-300">+94 72 372 2421</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-envelope text-blue-400 mr-4"></i>
                                <span class="text-gray-300">sritravelowner@gmail.com</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-clock text-blue-400 mr-4"></i>
                                <span class="text-gray-300">24/7 Service</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="border-t border-gray-700 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-400 text-sm mb-4 md:mb-0">
                        © 2025 SriTravel. All rights reserved.
                    </p>
                    <div class="flex space-x-6">
                        <a href="#" class="text-gray-400 hover:text-blue-400 text-sm">Privacy Policy</a>
                        <a href="#" class="text-gray-400 hover:text-blue-400 text-sm">Terms of Service</a>
                        <a href="#" class="text-gray-400 hover:text-blue-400 text-sm">Sitemap</a>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Mobile Booking Button -->
        <div class="fixed bottom-6 right-6 z-50 lg:hidden">
            <a href="<?php echo e(route('login')); ?>" class="bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-full p-4 shadow-lg flex items-center justify-center animate-bounce">
                <i class="fas fa-calendar-alt text-xl"></i>
                <span class="ml-2 hidden sm:inline">Sign In to Book</span>
            </a>
        </div>

        <!-- Back to Top Button -->
        <button id="back-to-top" class="fixed bottom-20 right-6 bg-gray-800 text-white w-12 h-12 rounded-full shadow-lg flex items-center justify-center hidden z-50 hover:bg-blue-600 transition duration-200">
            <i class="fas fa-arrow-up"></i>
        </button>
    <?php endif; ?>

    <script>
        // Mobile menu toggle for non-authenticated users
        <?php if(!auth()->check()): ?>
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // Back to top button
        const backToTopButton = document.getElementById('back-to-top');
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.remove('hidden');
            } else {
                backToTopButton.classList.add('hidden');
            }
        });

        backToTopButton.addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // Animation on scroll
        function animateOnScroll() {
            const elements = document.querySelectorAll('.animate-on-scroll');
            elements.forEach(element => {
                const elementPosition = element.getBoundingClientRect().top;
                const elementBottom = element.getBoundingClientRect().bottom;
                const screenPosition = window.innerHeight / 1.2;
                if (elementPosition < window.innerHeight && elementBottom > 0) {
                    element.classList.add('animated');
                } else {
                    element.classList.remove('animated');
                }
            });
        }
        window.addEventListener('load', animateOnScroll);
        window.addEventListener('scroll', animateOnScroll);

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 100,
                        behavior: 'smooth'
                    });
                }
            });
        });
        <?php endif; ?>

        // Filter handling
        document.addEventListener('DOMContentLoaded', function() {
            const typeFilters = document.querySelectorAll('.type-filter');
            const applyFiltersButton = document.getElementById('apply-filters');
            const minPriceInput = document.getElementById('min-price');
            const maxPriceInput = document.getElementById('max-price');
            const startDateInput = document.getElementById('start-date');
            const endDateInput = document.getElementById('end-date');
            const priceError = document.getElementById('price-error');
            const startDateError = document.getElementById('start-date-error');
            const endDateError = document.getElementById('end-date-error');

            // Parse URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            const selectedTypes = urlParams.get('types') ? urlParams.get('types').split(',') : ['all'];
            const minPrice = urlParams.get('min_price') || '';
            const maxPrice = urlParams.get('max_price') || '';
            const startDate = urlParams.get('start_date') || '';
            const endDate = urlParams.get('end_date') || '';

            // Set initial state of checkboxes
            typeFilters.forEach(filter => {
                if (filter.id === 'type-all' && selectedTypes.includes('all')) {
                    filter.checked = true;
                } else if (filter.id !== 'type-all' && selectedTypes.includes(filter.id.replace('type-', ''))) {
                    filter.checked = true;
                    document.getElementById('type-all').checked = false;
                }
            });

            // Set initial price and date inputs
            minPriceInput.value = minPrice;
            maxPriceInput.value = maxPrice;
            startDateInput.value = startDate;
            endDateInput.value = endDate;

            // Validate inputs
            function validateInputs() {
                let isValid = true;

                // Price validation
                const minPrice = parseFloat(minPriceInput.value) || 0;
                const maxPrice = parseFloat(maxPriceInput.value) || Infinity;
                if (minPrice > maxPrice && maxPriceInput.value !== '') {
                    isValid = false;
                    priceError.classList.remove('hidden');
                    minPriceInput.classList.add('date-input-error');
                    maxPriceInput.classList.add('date-input-error');
                } else {
                    priceError.classList.add('hidden');
                    minPriceInput.classList.remove('date-input-error');
                    maxPriceInput.classList.remove('date-input-error');
                }

                // Date validation
                const startDate = startDateInput.value ? new Date(startDateInput.value) : null;
                const endDate = endDateInput.value ? new Date(endDateInput.value) : null;
                const today = new Date();
                today.setHours(0, 0, 0, 0);

                if (startDate && startDate < today) {
                    isValid = false;
                    startDateError.classList.remove('hidden');
                    startDateInput.classList.add('date-input-error');
                } else {
                    startDateError.classList.add('hidden');
                    startDateInput.classList.remove('date-input-error');
                }

                if (startDate && endDate && startDate > endDate) {
                    isValid = false;
                    endDateError.classList.remove('hidden');
                    endDateInput.classList.add('date-input-error');
                } else {
                    endDateError.classList.add('hidden');
                    endDateInput.classList.remove('date-input-error');
                }

                applyFiltersButton.disabled = !isValid;
            }

            // Handle checkbox changes
            typeFilters.forEach(filter => {
                filter.addEventListener('change', function() {
                    if (this.id === 'type-all' && this.checked) {
                        typeFilters.forEach(f => {
                            if (f.id !== 'type-all') f.checked = false;
                        });
                    } else if (this.id !== 'type-all' && this.checked) {
                        document.getElementById('type-all').checked = false;
                    }

                    const atLeastOneSelected = Array.from(typeFilters).some(f => f.checked && f.id !== 'type-all');
                    if (!atLeastOneSelected && !document.getElementById('type-all').checked) {
                        document.getElementById('type-all').checked = true;
                    }
                });
            });

            // Validate inputs on change
            minPriceInput.addEventListener('input', validateInputs);
            maxPriceInput.addEventListener('input', validateInputs);
            startDateInput.addEventListener('input', validateInputs);
            endDateInput.addEventListener('input', validateInputs);

            // Apply filters
            applyFiltersButton.addEventListener('click', function() {
                const selectedTypes = Array.from(typeFilters)
                    .filter(f => f.checked && f.id !== 'type-all')
                    .map(f => f.id.replace('type-', ''));
                const minPrice = minPriceInput.value;
                const maxPrice = maxPriceInput.value;
                const startDate = startDateInput.value;
                const endDate = endDateInput.value;

                let url = new URL(window.location.href);
                url.searchParams.set('types', selectedTypes.length ? selectedTypes.join(',') : 'all');
                if (minPrice) url.searchParams.set('min_price', minPrice);
                else url.searchParams.delete('min_price');
                if (maxPrice) url.searchParams.set('max_price', maxPrice);
                else url.searchParams.delete('max_price');
                if (startDate) url.searchParams.set('start_date', startDate);
                else url.searchParams.delete('start_date');
                if (endDate) url.searchParams.set('end_date', endDate);
                else url.searchParams.delete('end_date');

                window.location.href = url.toString();
            });

            validateInputs();
        });
    </script>
</body>
</html><?php /**PATH C:\Users\User\Desktop\New folder\sritt\sritt\sritravel\sritravel\resources\views/vehicles/index.blade.php ENDPATH**/ ?>