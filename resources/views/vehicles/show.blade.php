<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SriTravel - {{ $vehicle->make }} {{ $vehicle->model }}</title>
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

        /* Feature and gallery styles */
        .feature-icon {
            width: 2.5rem;
            height: 2.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.5rem;
            background-color: #EFF6FF;
            color: #3B82F6;
            font-size: 1.25rem;
        }
        .gallery-image {
            transition: all 0.3s;
            cursor: pointer;
        }
        .gallery-image:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .spec-item {
            border-bottom: 1px dashed #E5E7EB;
            padding: 0.75rem 0;
        }
        .spec-item:last-child {
            border-bottom: none;
        }
        .hover-scale {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .hover-scale:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="font-sans bg-gray-50">
    @auth
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
                <img class="h-10 w-10 rounded-full mr-3" src="{{ auth()->user()->profile_photo ? asset('storage/'.auth()->user()->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=random' }}" alt="User avatar">
                <div>
                    <p class="font-medium">{{ auth()->user()->name }}</p>
                    <p class="text-blue-200 text-xs">{{ auth()->user()->email }}</p>
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
                        <a href="{{ route('dashboard') }}" class="text-blue-200 hover:text-white hover:bg-blue-700 flex items-center">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('vehicles.index') }}" class="text-white bg-blue-700 border-l-4 border-blue-400 flex items-center">
                            <i class="fas fa-car"></i> Browse Vehicles
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('bookings.index') }}" class="text-blue-200 hover:text-white hover:bg-blue-700 flex items-center">
                            <i class="fas fa-calendar-check"></i> My Bookings
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('profile.show') }}" class="text-blue-200 hover:text-white hover:bg-blue-700 flex items-center">
                            <i class="fas fa-user"></i> My Profile
                        </a>
                    </li>
                    
                </ul>
            </div>
            <div class="sidebar-footer p-4">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="{{ route('logout') }}" class="bg-red-500 !bg-red-500 text-white !text-white hover:bg-red-600 hover:!bg-red-600 hover:text-white hover:!text-white flex items-center w-full px-4 py-2 rounded-md text-sm font-medium" onclick="event.preventDefault(); this.closest('form').submit();">
                <i class="fas fa-sign-out-alt mr-2"></i> Logout
            </a>
        </form>
    </div>
        </div>

        <div class="main-content">
    @else
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
                <a href="/" class="text-blue-600 font-medium flex items-center transition duration-200">
                    <i class="fas fa-home mr-2"></i> Home
                </a>
                <a href="/vehicles" class="text-gray-600 hover:text-blue-600 font-medium flex items-center transition duration-200">
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
                <a href="{{ route('login') }}"
                   class="px-5 py-2 border border-blue-500 text-blue-600 font-medium rounded-full hover:bg-blue-50 flex items-center">
                    <i class="fas fa-sign-in-alt mr-2"></i> Sign In
                </a>
                <a href="{{ route('register') }}"
                   class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-full flex items-center">
                    <i class="fas fa-user-plus mr-2"></i> Register
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
                    <a href="{{ route('login') }}"
                       class="block text-center border border-blue-500 text-blue-600 font-medium rounded-full py-2 mb-2">
                        <i class="fas fa-sign-in-alt mr-2"></i> Sign In
                    </a>
                    <a href="{{ route('register') }}"
                       class="block text-center bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-full py-2">
                        <i class="fas fa-user-plus mr-2"></i> Register
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <div class="pt-20">
    @endauth

            <!-- Header -->
            <header class="bg-white shadow-md rounded-lg p-4 flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-semibold font-heading text-gray-800">{{ $vehicle->make }} {{ $vehicle->model }}</h1>
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <a href="/" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                                    <i class="fas fa-home mr-2"></i>
                                    Home
                                </a>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                                    <a href="{{ route('vehicles.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Vehicles</a>
                                </div>
                            </li>
                            <li aria-current="page">
                                <div class="flex items-center">
                                    <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $vehicle->make }} {{ $vehicle->model }}</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('vehicles.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-transparent rounded-lg font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-blue-600 hover:text-white active:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-200 transition">
                        <i class="fas fa-arrow-left mr-2"></i> Back to Vehicles
                    </a>
                </div>
            </header>

            <!-- Error Message -->
            @if (session('error'))
                <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Page Content -->
            <main>
                <div class="container mx-auto px-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Vehicle Details -->
                        <div class="lg:col-span-2">
                            <!-- Vehicle Gallery -->
                            <div class="bg-white shadow rounded-xl p-4 mb-6">
                                <div class="grid grid-cols-1 gap-4">
                                    <div class="relative h-48 w-full rounded-lg overflow-hidden">
                                        <img class="absolute h-full w-full object-cover" src="{{ $vehicle->image ? asset('storage/'.$vehicle->image) : asset('images/default-vehicle.jpg') }}" alt="{{ $vehicle->make }} {{ $vehicle->model }}">
                                    </div>
                                    <div class="grid grid-cols-3 gap-2">
                                        <div class="gallery-image h-24 rounded overflow-hidden">
                                            <img class="h-full w-full object-cover" src="{{ asset('images/vehicle-interior.jpg') }}" alt="Vehicle interior">
                                        </div>
                                        <div class="gallery-image h-24 rounded overflow-hidden">
                                            <img class="h-full w-full object-cover" src="{{ asset('images/vehicle-dashboard.jpg') }}" alt="Vehicle dashboard">
                                        </div>
                                        <div class="gallery-image h-24 rounded overflow-hidden">
                                            <img class="h-full w-full object-cover" src="{{ asset('images/vehicle-rear.jpg') }}" alt="Vehicle rear">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Vehicle Description -->
                            <div class="bg-white shadow rounded-xl p-6 mb-6">
                                <h2 class="text-lg font-semibold text-gray-800 mb-4">Vehicle Description</h2>
                                <div class="prose max-w-none text-gray-600">
                                    <p>The {{ $vehicle->make }} {{ $vehicle->model }} is a premium {{ $vehicle->type }} that combines comfort, style, and performance. With its {{ $vehicle->year }} model year, this vehicle offers modern features and reliable transportation.</p>
                                    <p class="mt-3">{{ $vehicle->description ?? 'This vehicle includes standard features like air conditioning, power windows, and a modern infotainment system. Ideal for both city driving and longer journeys.' }}</p>
                                </div>
                            </div>
                            
                            <!-- Features & Specifications -->
                            <div class="bg-white shadow rounded-xl p-6">
                                <h2 class="text-lg font-semibold text-gray-800 mb-4">Features & Specifications</h2>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <h3 class="text-base font-semibold text-gray-700 mb-3">Key Features</h3>
                                        <div class="space-y-3">
                                            @foreach($vehicle->features ?? ['Air Conditioning', 'Premium Audio', 'Safety Package'] as $feature)
                                                <div class="flex items-start">
                                                    <div class="feature-icon mr-3">
                                                        <i class="fas {{ $feature == 'Air Conditioning' ? 'fa-snowflake' : ($feature == 'Premium Audio' ? 'fa-music' : 'fa-shield-alt') }}"></i>
                                                    </div>
                                                    <div>
                                                        <h4 class="font-semibold text-gray-800">{{ $feature }}</h4>
                                                        <p class="text-sm text-gray-500">{{ $feature == 'Air Conditioning' ? 'Climate control for comfort' : ($feature == 'Premium Audio' ? 'High-quality sound system' : 'Advanced safety features') }}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="text-base font-semibold text-gray-700 mb-3">Technical Specifications</h3>
                                        <div class="bg-gray-50 rounded-lg p-4">
                                            <div class="spec-item flex justify-between">
                                                <span class="text-gray-600">Make</span>
                                                <span class="font-medium">{{ $vehicle->make }}</span>
                                            </div>
                                            <div class="spec-item flex justify-between">
                                                <span class="text-gray-600">Model</span>
                                                <span class="font-medium">{{ $vehicle->model }}</span>
                                            </div>
                                            <div class="spec-item flex justify-between">
                                                <span class="text-gray-600">Year</span>
                                                <span class="font-medium">{{ $vehicle->year }}</span>
                                            </div>
                                            <div class="spec-item flex justify-between">
                                                <span class="text-gray-600">Type</span>
                                                <span class="font-medium">{{ ucfirst($vehicle->type) }}</span>
                                            </div>
                                            <div class="spec-item flex justify-between">
                                                <span class="text-gray-600">Registration</span>
                                                <span class="font-medium">{{ $vehicle->registration_number }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Booking Panel -->
                        <div>
                            <div class="bg-white shadow rounded-xl p-6 sticky top-6">
                                <div class="flex justify-between items-start mb-4">
                                    <h2 class="text-lg font-semibold text-gray-800">Book This Vehicle</h2>
                                    <div class="text-xl font-bold text-blue-600">Rs. {{ number_format($vehicle->price_per_km, 2) }}<span class="text-sm font-normal text-gray-500"> / km</span></div>
                                </div>
                                
                                <a href="{{ auth()->check() ? route('bookings.create', ['vehicle_id' => $vehicle->id, 'price_per_km' => $vehicle->price_per_km]) : route('login') }}" class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-lg shadow-md transition duration-300 hover:scale-105 mb-6">
                                    <i class="fas fa-calendar-check mr-2"></i> {{ auth()->check() ? 'Book Now' : 'Sign In to Book' }}
                                </a>
                                
                                <div class="space-y-4">
                                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-3">
                                            <i class="fas fa-car"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-800">Free Cancellation</h4>
                                            <p class="text-sm text-gray-500">Cancel up to 24 hours before pickup</p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-3">
                                            <i class="fas fa-shield-alt"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-800">Full Insurance</h4>
                                            <p class="text-sm text-gray-500">Comprehensive coverage included</p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-3">
                                            <i class="fas fa-road"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-800">Unlimited Mileage</h4>
                                            <p class="text-sm text-gray-500">No extra charges for distance</p>
                                        </div>
                                    </div>
                                    
                                    <div class="pt-4 border-t border-gray-200">
                                        <h3 class="text-sm font-semibold text-gray-700 mb-2">Need Help?</h3>
                                        <div class="space-y-2">
                                            <a href="#" class="flex items-center text-blue-600 hover:text-blue-800 text-sm">
                                                <i class="fas fa-phone-alt mr-2"></i> +94 11 234 5678
                                            </a>
                                            <a href="#" class="flex items-center text-blue-600 hover:text-blue-800 text-sm">
                                                <i class="fas fa-envelope mr-2"></i> support@sritravel.com
                                            </a>
                                            <a href="#" class="flex items-center text-blue-600 hover:text-blue-800 text-sm">
                                                <i class="fas fa-comment-alt mr-2"></i> Live Chat
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
    @auth
        </div>
    </div>
    @else
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
            <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-full p-4 shadow-lg flex items-center justify-center animate-bounce">
                <i class="fas fa-calendar-alt text-xl"></i>
                <span class="ml-2 hidden sm:inline">Sign In to Book</span>
            </a>
        </div>

        <!-- Back to Top Button -->
        <button id="back-to-top" class="fixed bottom-20 right-6 bg-gray-800 text-white w-12 h-12 rounded-full shadow-lg flex items-center justify-center hidden z-50 hover:bg-blue-600 transition duration-200">
            <i class="fas fa-arrow-up"></i>
        </button>
    @endauth

    <script>
        // Mobile menu toggle and other scripts for non-authenticated users
        @if(!auth()->check())
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
        @endif

        // Gallery image click handler
        document.querySelectorAll('.gallery-image').forEach(image => {
            image.addEventListener('click', function() {
                console.log('Viewing image:', this.querySelector('img').alt);
            });
        });
    </script>
</body>
</html>