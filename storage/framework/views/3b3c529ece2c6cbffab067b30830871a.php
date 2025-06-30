<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SriTravel - Contact Us</title>
    <meta name="description" content="Contact SriTravel Pvt Ltd for premium vehicle rentals in Sri Lanka. Reach out for bookings or inquiries.">
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
        .section-divider {
            width: 80px;
            height: 4px;
            background: #3B82F6;
            margin: 1rem auto;
        }
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
                <a href="/" class="text-gray-600 hover:text-blue-600 font-medium flex items-center transition duration-200">
                    <i class="fas fa-home mr-2"></i> Home
                </a>
                <a href="<?php echo e(route('vehicles.index')); ?>" class="text-gray-600 hover:text-blue-600 font-medium flex items-center transition duration-200">
                    <i class="fas fa-car mr-2"></i> Vehicles
                </a>
                <a href="/about" class="text-gray-600 hover:text-blue-600 font-medium flex items-center transition duration-200">
                    <i class="fas fa-info-circle mr-2"></i> About 
                </a>
                <a href="/contact" class="text-blue-600 font-medium flex items-center transition duration-200">
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
                <a href="/" class="text-gray-600 hover:text-blue-600 font-medium">
                    <i class="fas fa-home mr-2"></i> Home
                </a>
                <a href="<?php echo e(route('vehicles.index')); ?>" class="text-gray-600 hover:text-blue-600 font-medium flex items-center transition duration-200">
                    <i class="fas fa-car mr-2"></i> Vehicles
                </a>
                <a href="/about" class="text-gray-600 hover:text-blue-600 font-medium">
                    <i class="fas fa-info-circle mr-2"></i> About
                </a>
                <a href="/contact" class="text-blue-600 font-medium">
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

    <!-- Contact Us Section -->
    <section class="py-16 bg-gray-50 pt-32">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12 animate-on-scroll fade-in">
                <span class="text-blue-600 font-semibold uppercase tracking-wider">CONTACT US</span>
                <h2 class="text-3xl md:text-4xl font-bold font-heading text-gray-800 mt-2">Get in Touch</h2>
                <div class="section-divider"></div>
                <p class="text-gray-600 mt-4 max-w-2xl mx-auto">We'd love to hear from you! Fill out the form below, and our team will respond promptly.</p>
            </div>
            <div class="flex justify-center">
                <!-- Contact Form -->
                <div class="w-full max-w-2xl animate-on-scroll slide-up">
                    <div class="bg-white shadow-lg rounded-xl p-10 border border-gray-100">
                        <h3 class="text-2xl font-bold font-heading text-gray-800 mb-8 text-center">Send Us a Message</h3>
                        <?php if(session('success')): ?>
                            <div class="bg-green-100 text-green-800 p-4 rounded-lg mb-8 flex items-center">
                                <i class="fas fa-check-circle mr-2"></i>
                                <?php echo e(session('success')); ?>

                            </div>
                        <?php endif; ?>
                        <?php if(session('error')): ?>
                            <div class="bg-red-100 text-red-800 p-4 rounded-lg mb-8 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                <?php echo e(session('error')); ?>

                            </div>
                        <?php endif; ?>
                        <form action="<?php echo e(route('contact.submit')); ?>" method="POST" class="space-y-8">
                            <?php echo csrf_field(); ?>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-gray-700 font-medium mb-2">Name</label>
                                    <div class="relative">
                                        <i class="fas fa-user absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                        <input type="text" id="name" name="name" required
                                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50"
                                               placeholder="Your Name">
                                    </div>
                                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div>
                                    <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                                    <div class="relative">
                                        <i class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                        <input type="email" id="email" name="email" required
                                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50"
                                               placeholder="Your Email">
                                    </div>
                                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div>
                                <label for="subject" class="block text-gray-700 font-medium mb-2">Subject</label>
                                <div class="relative">
                                    <i class="fas fa-tag absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    <input type="text" id="subject" name="subject" required
                                           class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50"
                                           placeholder="Subject">
                                </div>
                                <?php $__errorArgs = ['subject'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div>
                                <label for="message" class="block text-gray-700 font-medium mb-2">Message</label>
                                <div class="relative">
                                    <i class="fas fa-comment absolute left-3 top-4 text-gray-400"></i>
                                    <textarea id="message" name="message" required
                                              class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50"
                                              rows="6" placeholder="Your Message"></textarea>
                                </div>
                                <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <button type="submit"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition duration-200 hover-scale flex items-center justify-center">
                                <i class="fas fa-paper-plane mr-2"></i> Send Message
                            </button>
                        </form>
                    </div>
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
                        <li><a href="/contact" class="text-blue-400 transition duration-200"><i class="fas fa-chevron-right text-xs mr-2"></i> Contact</a></li>
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
    </script>
</body>
</html><?php /**PATH C:\Users\Dell\Desktop\sritravel\sritravel\resources\views/contact.blade.php ENDPATH**/ ?>