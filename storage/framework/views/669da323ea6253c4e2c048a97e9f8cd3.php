<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="<?php echo e(asset('images/favicon-32x32.png')); ?>">
    <title>SriTravel - Admin Add New Vehicle</title>
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

        .file-upload-preview {
            max-width: 100%;
            max-height: 192px; /* Matches h-48 from index/show */
            margin-top: 10px;
            display: none;
            object-fit: cover;
            border-radius: 0.5rem;
        }

        .form-section {
            max-height: 360px; /* Matches vehicle card height from index */
            overflow-y: auto;
            padding-right: 1rem;
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
<body class="font-sans antialiased bg-gray-50">
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
                        <a href="<?php echo e(route('admin.vehicles.index')); ?>" class="text-white bg-blue-700 border-l-4 border-blue-400 flex items-center">
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
            <header class="bg-white shadow-sm rounded-lg p-4 flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold font-heading text-gray-800">Add New Vehicle</h2>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600"><?php echo e(auth()->user()->name); ?></span>
                    <img class="h-10 w-10 rounded-full mr-3" src="<?php echo e(auth()->user()->profile_photo ? asset('storage/'.auth()->user()->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=random'); ?>" alt="<?php echo e(auth()->user()->name); ?> avatar">
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-4">
                <!-- Error Messages -->
                <?php if($errors->any()): ?>
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg" role="alert">
                        <strong>Whoops! Something went wrong.</strong>
                        <ul class="list-disc pl-5 mt-2">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg" role="alert">
                        <?php echo e(session('error')); ?>

                    </div>
                <?php endif; ?>

                <!-- Form -->
                <div class="bg-white shadow-sm rounded-lg p-4">
                    <form action="<?php echo e(route('admin.vehicles.store')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Basic Information -->
                            <div class="form-section space-y-4">
                                <h3 class="text-lg font-semibold text-gray-800">Basic Information</h3>
                                <div>
                                    <label for="make" class="block text-sm font-medium text-gray-700">Make *</label>
                                    <input type="text" name="make" id="make" value="<?php echo e(old('make')); ?>" required
                                           class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-600 focus:border-blue-600 sm:text-sm"
                                           placeholder="e.g., Toyota">
                                </div>
                                <div>
                                    <label for="model" class="block text-sm font-medium text-gray-700">Model *</label>
                                    <input type="text" name="model" id="model" value="<?php echo e(old('model')); ?>" required
                                           class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-600 focus:border-blue-600 sm:text-sm"
                                           placeholder="e.g., Camry">
                                </div>
                                <div>
                                    <label for="year" class="block text-sm font-medium text-gray-700">Year *</label>
                                    <input type="number" name="year" id="year" value="<?php echo e(old('year')); ?>" min="1900" max="2025" required
                                           class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-600 focus:border-blue-600 sm:text-sm"
                                           placeholder="e.g., 2022">
                                </div>
                                <div>
                                    <label for="registration_number" class="block text-sm font-medium text-gray-700">Registration Number *</label>
                                    <input type="text" name="registration_number" id="registration_number" value="<?php echo e(old('registration_number')); ?>" required
                                           class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-600 focus:border-blue-600 sm:text-sm"
                                           placeholder="e.g., WP QL 9904, WP CAT 0021, WP 1234, WP-1234, 12-3456">
                                </div>
                            </div>

                            <!-- Vehicle Details -->
                            <div class="form-section space-y-4">
                                <h3 class="text-lg font-semibold text-gray-800">Vehicle Details</h3>
                                <div>
                                    <label for="type" class="block text-sm font-medium text-gray-700">Vehicle Type *</label>
                                    <select name="type" id="type" required
                                            class="mt-1 block w-full pl-3 pr-10 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-600 focus:border-blue-600 sm:text-sm">
                                        <option value="">Select Type</option>
                                        <option value="car" <?php echo e(old('type') == 'car' ? 'selected' : ''); ?>>Car</option>
                                        <option value="cab" <?php echo e(old('type') == 'cab' ? 'selected' : ''); ?>>Cab</option>
                                        <option value="van" <?php echo e(old('type') == 'van' ? 'selected' : ''); ?>>Van</option>
                                        <option value="minibus" <?php echo e(old('type') == 'minibus' ? 'selected' : ''); ?>>MiniBus</option>
                                        <option value="bus" <?php echo e(old('type') == 'bus' ? 'selected' : ''); ?>>Bus</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="price_per_km" class="block text-sm font-medium text-gray-700">Price Per km (LKR) *</label>
                                    <input type="number" name="price_per_km" id="price_per_km" value="<?php echo e(old('price_per_km')); ?>" min="0" step="0.01" required
                                           class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-600 focus:border-blue-600 sm:text-sm"
                                           placeholder="e.g., 50.00">
                                </div>
                                <div>
                                    <label for="passengers" class="block text-sm font-medium text-gray-700">Passengers *</label>
                                    <input type="number" name="passengers" id="passengers" value="<?php echo e(old('passengers')); ?>" min="1" max="50" required
                                           class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-600 focus:border-blue-600 sm:text-sm"
                                           placeholder="e.g., 5">
                                </div>
                                <div>
                                    <label for="features" class="block text-sm font-medium text-gray-700">Features</label>
                                    <input type="text" name="features" id="features" value="<?php echo e(old('features', '')); ?>"
                                           class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-600 focus:border-blue-600 sm:text-sm"
                                           placeholder="e.g., Air Conditioning, GPS">
                                    <p class="text-xs text-gray-500 mt-1">Enter multiple features (comma-separated).</p>
                                </div>
                            </div>

                            <!-- Description and Availability -->
                            <div class="col-span-1 md:col-span-2 space-y-4">
                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                    <textarea name="description" id="description" rows="3"
                                              class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-600 focus:border-blue-600 sm:text-sm"
                                              placeholder="e.g., Comfortable sedan for city travel"><?php echo e(old('description')); ?></textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Availability</label>
                                    <div class="mt-1 flex items-center">
                                        <input id="available" name="available" type="checkbox" value="1" <?php echo e(old('available', false) ? 'checked' : ''); ?>

                                               class="h-4 w-4 text-blue-600 focus:ring-blue-600 border-gray-300 rounded">
                                        <label for="available" class="ml-2 block text-sm text-gray-700">
                                            Available for booking
                                        </label>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Vehicle Image</label>
                                    <div class="mt-1">
                                        <div id="fileUploadContainer" class="flex flex-col items-center p-4 border-2 border-dashed border-gray-300 rounded-lg bg-gray-50 cursor-pointer hover:border-blue-600 hover:bg-blue-50 transition duration-200">
                                            <i class="fas fa-cloud-upload-alt text-3xl text-blue-600 mb-2"></i>
                                            <p class="text-sm text-gray-600">Click to upload or drag and drop</p>
                                            <p class="text-xs text-gray-500 mt-1">PNG, JPG, JPEG up to 5MB</p>
                                            <input type="file" name="image" id="image" accept="image/*" class="hidden">
                                            <img id="imagePreview" class="file-upload-preview">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4 flex justify-end space-x-3">
                            <a href="<?php echo e(route('admin.vehicles.index')); ?>" class="bg-white py-2 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 transition duration-200 hover:scale-105">
                                Add Vehicle
                            </button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Image upload preview
        document.getElementById('fileUploadContainer').addEventListener('click', function() {
            document.getElementById('image').click();
        });

        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const preview = document.getElementById('imagePreview');
                    preview.src = event.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });

        // Drag and drop functionality
        const fileUploadContainer = document.getElementById('fileUploadContainer');
        
        fileUploadContainer.addEventListener('dragover', (e) => {
            e.preventDefault();
            fileUploadContainer.classList.add('border-blue-600', 'bg-blue-50');
        });

        fileUploadContainer.addEventListener('dragleave', () => {
            fileUploadContainer.classList.remove('border-blue-600', 'bg-blue-50');
        });

        fileUploadContainer.addEventListener('drop', (e) => {
            e.preventDefault();
            fileUploadContainer.classList.remove('border-blue-600', 'bg-blue-50');
            
            if (e.dataTransfer.files.length) {
                document.getElementById('image').files = e.dataTransfer.files;
                const file = e.dataTransfer.files[0];
                const reader = new FileReader();
                reader.onload = function(event) {
                    const preview = document.getElementById('imagePreview');
                    preview.src = event.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html><?php /**PATH D:\fproject\project\project\sritravel\sritravel\resources\views/admin/vehicles/create.blade.php ENDPATH**/ ?>