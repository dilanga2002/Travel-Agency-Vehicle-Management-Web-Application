<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SriTravel - Premium Vehicle Rentals in Sri Lanka</title>
    <meta name="description" content="SriTravel offers premium vehicle rentals with professional drivers for exploring Sri Lanka in comfort and style.">
    <link rel="icon" type="image/png" href="<?php echo e(asset('images/favicon-32x32.png')); ?>">
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
        .hover-scale {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .hover-scale:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        .hero-overlay {
            background: rgba(0, 0, 0, 0.4);
        }
        .section-divider {
            width: 80px;
            height: 4px;
            background: #3B82F6;
            margin: 1rem auto;
        }
        .step-connector::after {
            content: '';
            position: absolute;
            top: 2.5rem;
            left: 100%;
            width: 2rem;
            height: 2px;
            background-color: #1E3A8A;
        }
        @media (max-width: 768px) {
            .step-connector::after {
                display: none;
            }
        }
        .bg-image-darken {
            position: relative;
        }
        .bg-image-darken::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
            z-index: 0;
        }
        
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
        .slide-left {
            transform: translateX(50px);
        }
        .slide-left.animated {
            transform: translateX(0);
        }
        .fade-in {
            opacity: 0;
        }
        .fade-in.animated {
            opacity: 1;
        }
        
        /* Slideshow */
        .slideshow-container {
            position: relative;
            width: 100%;
            height: 100%;
        }
        .slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 1s ease-in-out;
            background-size: cover;
            background-position: center;
        }
        .slide.active {
            opacity: 1;
        }
        
        /* Vehicle card styles */
        .vehicle-card {
            transition: all 0.3s;
        }
        .vehicle-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-white text-gray-700 font-sans scroll-smooth">

    <!-- Modern Navbar -->
    <nav class="bg-white text-gray-800 py-4 shadow-sm fixed top-0 w-full z-50">
        <div class="container mx-auto px-6 flex justify-between items-center">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="/" class="text-2xl font-bold font-heading flex items-center">
                    <i class="fas fa-car text-blue-500 mr-2"></i>
                    <span class="text-blue-600">Sri</span><span class="text-gray-800">Travel</span>
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden lg:flex items-center space-x-8">
                <a href="/" class="text-blue-600 font-medium flex items-center transition duration-200">
                    <i class="fas fa-home mr-2"></i> Home
                </a>
                <a href="<?php echo e(route('vehicles.index')); ?>" class="text-gray-600 hover:text-blue-600 font-medium flex items-center transition duration-200">
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
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('dashboard')); ?>"
                       class="px-5 py-2 border border-blue-500 text-blue-600 font-medium rounded-full hover:bg-blue-50 flex items-center">
                        <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                    </a>
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit"
                                class="px-5 py-2 bg-red-500 hover:bg-red-600 text-white font-medium rounded-full flex items-center">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </button>
                    </form>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>"
                       class="px-5 py-2 border border-blue-500 text-blue-600 font-medium rounded-full hover:bg-blue-50 flex items-center">
                        <i class="fas fa-sign-in-alt mr-2"></i> Sign In
                    </a>
                    <a href="<?php echo e(route('register')); ?>"
                       class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-full flex items-center">
                        <i class="fas fa-user-plus mr-2"></i> Sign Up
                    </a>
                <?php endif; ?>
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
                <a href="<?php echo e(route('vehicles.index')); ?>" class="text-gray-600 hover:text-blue-600 font-medium flex items-center transition duration-200">
                    <i class="fas fa-car mr-2"></i> Vehicles
                </a>
                <a href="/about" class="text-gray-600 hover:text-blue-600 font-medium">
                    <i class="fas fa-info-circle mr-2"></i> About Us
                </a>
                <a href="/contact" class="text-gray-600 hover:text-blue-600 font-medium">
                    <i class="fas fa-phone-alt mr-2"></i> Contact
                </a>

                <div class="pt-2 border-t border-gray-200">
                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(route('dashboard')); ?>"
                           class="block text-center border border-blue-500 text-blue-600 font-medium rounded-full py-2 mb-2">
                            <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                        </a>
                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit"
                                    class="w-full block text-center bg-red-600 hover:bg-red-700 text-white font-medium rounded-full py-2">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </button>
                        </form>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>"
                           class="block text-center border border-blue-500 text-blue-600 font-medium rounded-full py-2 mb-2">
                            <i class="fas fa-sign-in-alt mr-2"></i> Sign In
                        </a>
                        <a href="<?php echo e(route('register')); ?>"
                           class="block text-center bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-full py-2">
                            <i class="fas fa-user-plus mr-2"></i> Sign Up
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section with Slideshow -->
    <section id="hero" class="relative pt-32 pb-20 md:pb-32 h-screen min-h-[600px]">
        <div class="slideshow-container absolute inset-0">
            <div class="slide active" style="background-image: url('https://jetwingtravels.com/wp-content/uploads/2024/01/home-desctop.jpg');"></div>
            <div class="slide" style="background-image: url('https://jetwingtravels.com/wp-content/uploads/2024/01/2pic2.jpg');"></div>
            
        </div>
        <div class="hero-overlay absolute inset-0"></div>
        
        <div class="container mx-auto px-6 relative z-10 h-full flex items-center">
            <div class="flex flex-col lg:flex-row items-center w-full">
                <div class="lg:w-1/2 text-white mb-10 lg:mb-0 animate-on-scroll slide-right">
                    <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold font-heading mb-4 leading-tight">
                        Explore Sri Lanka in <span class="text-blue-400">Confidence</span> & <span class="text-blue-400">Comfort</span>
                    </h1>
                    <p class="text-xl md:text-2xl mb-8 max-w-lg">
                        Welcome to SriTravel Pvt Ltd – your trusted partner for trip-based vehicle rentals across Sri Lanka.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="<?php echo e(route('vehicles.index')); ?>" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-full hover-scale">
                            <i class="fas fa-car mr-2"></i> Find Your Vehicle
                        </a>
                        <a href="<?php echo e(route('bookings.create')); ?>" class="border-2 border-white hover:bg-white hover:text-blue-600 text-white font-semibold px-6 py-3 rounded-full hover-scale">
                            <i class="fas fa-calendar-check mr-2"></i> Book Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About SriTravel Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12 animate-on-scroll fade-in">
                <span class="text-blue-600 font-semibold uppercase tracking-wider">WELCOME TO SRITRAVEL</span>
                <h2 class="text-3xl md:text-4xl font-bold font-heading text-gray-800 mt-2">Your Journey, Our Passion</h2>
                <div class="section-divider"></div>
            </div>
            <div class="flex flex-col lg:flex-row items-center gap-8 animate-on-scroll slide-up">
                <div class="lg:w-1/2 min-h-[400px]">
                    <img id="about-image" src="https://rent.tanaakk.com/wp-content/uploads/2023/10/TANAAKKtop-1-min.jpeg" alt="Sri Lankan travel scene" class="w-full object-cover rounded-lg shadow-md hover-scale">
                </div>
                <div class="lg:w-1/2">
                    <p id="about-paragraph" class="text-gray-600 text-lg leading-relaxed">
                        At SriTravel Pvt Ltd, we specialize in providing vehicle rental services exclusively for travel and tour purposes across Sri Lanka. Our fleet, which includes well-maintained cars, cabs, vans, minibuses, and buses, is offered only for long-distance trips, sightseeing tours, and planned journeys—we do not provide vehicles for airport transfers, short-distance travel, or personal transport needs. All bookings and transport arrangements are personally managed by the owner, ensuring a reliable and customized service for each client. Please note that we do not offer online payments; all trip reservations must be made directly through the owner. With a strong focus on customer satisfaction and a clear trip-only policy, SriTravel Pvt Ltd continues to serve as a trusted travel partner for both local and international travelers seeking comfortable and safe transport across the island.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Trust Indicators -->
    <div class="bg-gray-50 py-8">
        <div class="container mx-auto px-6">
            <div class="flex flex-wrap justify-center items-center gap-8 md:gap-12 animate-on-scroll slide-up">
                <div class="flex items-center">
                    <div class="bg-blue-100 p-3 rounded-full mr-3">
                        <i class="fas fa-shield-alt text-xl text-blue-600"></i>
                    </div>
                    <div>
                        <div class="font-bold text-gray-800">Fully Insured</div>
                        <div class="text-sm text-gray-500">All vehicles</div>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="bg-blue-100 p-3 rounded-full mr-3">
                        <i class="fas fa-user-tie text-xl text-blue-600"></i>
                    </div>
                    <div>
                        <div class="font-bold text-gray-800">Professional Drivers</div>
                        <div class="text-sm text-gray-500">Licensed & trained</div>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="bg-blue-100 p-3 rounded-full mr-3">
                        <i class="fas fa-headset text-xl text-blue-600"></i>
                    </div>
                    <div>
                        <div class="font-bold text-gray-800">24/7 Support</div>
                        <div class="text-sm text-gray-500">Always available</div>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="bg-blue-100 p-3 rounded-full mr-3">
                        <i class="fas fa-hand-holding-usd text-xl text-blue-600"></i>
                    </div>
                    <div>
                        <div class="font-bold text-gray-800">Best Price</div>
                        <div class="text-sm text-gray-500">Guaranteed</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Vehicles Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12 animate-on-scroll fade-in">
                <span class="text-blue-600 font-semibold uppercase tracking-wider">OUR FLEET</span>
                <h2 class="text-3xl md:text-4xl font-bold font-heading text-gray-800 mt-2">Featured Vehicles</h2>
                <div class="section-divider"></div>
            </div>
            <?php if($vehicles->isEmpty()): ?>
                <div class="bg-white shadow rounded-xl p-6 text-center">
                    <i class="fas fa-car-side text-4xl text-gray-300 mb-3"></i>
                    <h3 class="text-lg font-semibold text-gray-700">No Vehicles Available</h3>
                    <p class="text-gray-500 mt-1">Please check back later.</p>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="vehicle-card bg-white shadow rounded-xl overflow-hidden animate-on-scroll slide-up">
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
                                <a href="<?php echo e(auth()->check() ? route('bookings.create', ['vehicle_id' => $vehicle->id, 'price_per_km' => $vehicle->price_per_km]) : route('login')); ?>" class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition duration-300 hover-scale">
                                    <i class="fas fa-calendar-check mr-2"></i> <?php echo e(auth()->check() ? 'Book Now' : 'Sign In to Book'); ?>

                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class="mt-8 text-center">
                    <a href="<?php echo e(route('vehicles.index')); ?>" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-full transition duration-200 hover-scale">
                        <i class="fas fa-car mr-2"></i> View All Vehicles
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12 animate-on-scroll fade-in">
                <span class="text-blue-600 font-semibold uppercase tracking-wider">WHY CHOOSE US</span>
                <h2 class="text-3xl md:text-4xl font-bold font-heading text-gray-800 mt-2">Your Trusted Travel Partner</h2>
                <div class="section-divider"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center p-6 rounded-xl hover-scale bg-white shadow-sm animate-on-scroll slide-up" style="transition-delay: 0.1s">
                    <div class="w-20 h-20 mx-auto mb-6 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-award text-3xl text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-bold font-heading mb-3">Award-Winning Service</h3>
                    <p class="text-gray-600">Recognized as the best vehicle rental service in Sri Lanka for 3 consecutive years.</p>
                </div>

                <div class="text-center p-6 rounded-xl hover-scale bg-white shadow-sm animate-on-scroll slide-up" style="transition-delay: 0.2s">
                    <div class="w-20 h-20 mx-auto mb-6 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-shield-alt text-3xl text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-bold font-heading mb-3">Safety First</h3>
                    <p class="text-gray-600">All vehicles undergo rigorous safety checks and are equipped with modern safety features.</p>
                </div>

                <div class="text-center p-6 rounded-xl hover-scale bg-white shadow-sm animate-on-scroll slide-up" style="transition-delay: 0.3s">
                    <div class="w-20 h-20 mx-auto mb-6 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-hand-holding-usd text-3xl text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-bold font-heading mb-3">Best Price Guarantee</h3>
                    <p class="text-gray-600">We promise the best rates for premium vehicles with no hidden charges.</p>
                </div>

                <div class="text-center p-6 rounded-xl hover-scale bg-white shadow-sm animate-on-scroll slide-up" style="transition-delay: 0.4s">
                    <div class="w-20 h-20 mx-auto mb-6 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-headset text-3xl text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-bold font-heading mb-3">24/7 Support</h3>
                    <p class="text-gray-600">Our customer service team is available round the clock to assist you.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12 animate-on-scroll fade-in">
                <span class="text-blue-600 font-semibold uppercase tracking-wider">EASY STEPS</span>
                <h2 class="text-3xl md:text-4xl font-bold font-heading text-gray-800 mt-2">How It Works</h2>
                <div class="section-divider"></div>
            </div>

            <div class="flex flex-col md:flex-row justify-center items-center">
                <!-- Step 1 -->
                <div class="relative flex flex-col items-center p-6 md:w-1/4 step-connector animate-on-scroll slide-right">
                    <div class="w-20 h-20 rounded-full bg-blue-600 text-white text-2xl font-bold flex items-center justify-center mb-4 z-10">
                        1
                    </div>
                    <h3 class="text-xl font-bold font-heading mb-2 text-center">Choose Your Vehicle</h3>
                    <p class="text-gray-600 text-center">Browse our fleet and select the perfect vehicle for your needs.</p>
                </div>

                <!-- Step 2 -->
                <div class="relative flex flex-col items-center p-6 md:w-1/4 step-connector animate-on-scroll slide-right" style="transition-delay: 0.2s">
                    <div class="w-20 h-20 rounded-full bg-blue-600 text-white text-2xl font-bold flex items-center justify-center mb-4 z-10">
                        2
                    </div>
                    <h3 class="text-xl font-bold font-heading mb-2 text-center">Booking</h3>
                    <p class="text-gray-600 text-center">Select your dates and complete your booking by contacting us directly.</p>
                </div>

                <!-- Step 3 -->
                <div class="relative flex flex-col items-center p-6 md:w-1/4 step-connector animate-on-scroll slide-right" style="transition-delay: 0.4s">
                    <div class="w-20 h-20 rounded-full bg-blue-600 text-white text-2xl font-bold flex items-center justify-center mb-4 z-10">
                        3
                    </div>
                    <h3 class="text-xl font-bold font-heading mb-2 text-center">Meet Your Driver</h3>
                    <p class="text-gray-600 text-center">Your professional driver will meet you at the designated location.</p>
                </div>

                <!-- Step 4 -->
                <div class="flex flex-col items-center p-6 md:w-1/4 animate-on-scroll slide-right" style="transition-delay: 0.6s">
                    <div class="w-20 h-20 rounded-full bg-blue-600 text-white text-2xl font-bold flex items-center justify-center mb-4 z-10">
                        4
                    </div>
                    <h3 class="text-xl font-bold font-heading mb-2 text-center">Enjoy Your Journey</h3>
                    <p class="text-gray-600 text-center">Relax and enjoy your trip with our premium service.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-cover bg-center bg-image-darken animate-on-scroll fade-in" style="background-image: url('https://jetwingtravels.com/wp-content/uploads/2024/01/2pic2.jpg');">
        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-3xl mx-auto text-center text-white">
                <h2 class="text-3xl md:text-4xl font-bold font-heading mb-6">Ready to Explore Sri Lanka?</h2>
                <p class="text-xl mb-8">
                    Book your perfect vehicle today and experience the beauty of Sri Lanka in Confidence and comfort.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="<?php echo e(route('vehicles.index')); ?>" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-full transition duration-200 hover-scale inline-flex items-center justify-center">
                        <i class="fas fa-car mr-2"></i> Find Your Vehicle
                    </a>
                    <a href="/contact" class="border-2 border-white hover:bg-white hover:text-blue-600 text-white font-semibold py-3 px-8 rounded-full transition duration-200 hover-scale inline-flex items-center justify-center">
                        <i class="fas fa-phone-alt mr-2"></i> Contact Us
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
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
                        <li><a href="<?php echo e(route('vehicles.index')); ?>" class="text-gray-300 hover:text-blue-400 transition duration-200"><i class="fas fa-chevron-right text-xs mr-2"></i> Vehicles</a></li>
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
        <a href="<?php echo e(route('bookings.create')); ?>" class="bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-full p-4 shadow-lg flex items-center justify-center animate-bounce">
            <i class="fas fa-calendar-alt text-xl"></i>
            <span class="ml-2 hidden sm:inline">Book Now</span>
        </a>
    </div>

    <!-- Back to Top Button -->
    <button id="back-to-top" class="fixed bottom-20 right-6 bg-gray-800 text-white w-12 h-12 rounded-full shadow-lg flex items-center justify-center hidden z-50 hover:bg-blue-600 transition duration-200">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Scripts -->
    <script>
        // Mobile menu toggle
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

        // Slideshow functionality
        let currentSlide = 0;
        const slides = document.querySelectorAll('.slide');
        
        function showSlide(n) {
            slides.forEach(slide => slide.classList.remove('active'));
            currentSlide = (n + slides.length) % slides.length;
            slides[currentSlide].classList.add('active');
        }
        
        function nextSlide() {
            showSlide(currentSlide + 1);
        }
        
        // Change slide every 5 seconds
        setInterval(nextSlide, 5000);
        
        // Initialize first slide
        showSlide(0);

        // Animation on scroll
        function animateOnScroll() {
            const elements = document.querySelectorAll('.animate-on-scroll');
            
            elements.forEach(element => {
                const elementPosition = element.getBoundingClientRect().top;
                const elementBottom = element.getBoundingClientRect().bottom;
                const screenPosition = window.innerHeight / 1.2;
                
                // Check if element is in viewport
                if (elementPosition < window.innerHeight && elementBottom > 0) {
                    element.classList.add('animated');
                } else {
                    element.classList.remove('animated');
                }
            });
        }
        
        // Run on load and scroll
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

        // Match image height to paragraph height
        function matchImageHeight() {
            const paragraph = document.getElementById('about-paragraph');
            const image = document.getElementById('about-image');
            if (paragraph && image) {
                const paragraphHeight = paragraph.offsetHeight;
                image.parentElement.style.minHeight = `${paragraphHeight + 50}px`; // Add extra padding
                image.style.height = `${paragraphHeight + 50}px`; // Match with extra padding
            }
        }

        // Run on load
        window.addEventListener('load', matchImageHeight);

        // Update height on window resize
        window.addEventListener('resize', matchImageHeight);
    </script>
</body>
</html><?php /**PATH C:\Users\Dell\Desktop\sritravel\sritravel\resources\views/welcome.blade.php ENDPATH**/ ?>