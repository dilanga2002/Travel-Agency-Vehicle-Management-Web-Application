<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="<?php echo e(asset('images/favicon-32x32.png')); ?>">
    <title>SriTravel - Admin Edit Driver</title>
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

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .file-upload-preview {
            max-width: 100%;
            max-height: 200px;
            margin-top: 10px;
            display: none;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }
            .main-content {
                margin-left: 200px;
                width: calc(100% - 200px);
            }
            .form-grid {
                grid-template-columns: 1fr;
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
                        <a href="<?php echo e(route('admin.vehicles.index')); ?>" class="text-blue-200 hover:text-white hover:bg-blue-700 flex items-center">
                            <i class="fas fa-car"></i> Vehicles
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('admin.drivers.index')); ?>" class="text-white bg-blue-700 border-l-4 border-blue-400 flex items-center">
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
                <h2 class="text-xl font-semibold font-heading text-gray-800">Edit Driver</h2>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600"><?php echo e(auth()->user()->name); ?></span>
                    <img class="h-10 w-10 rounded-full mr-3" src="<?php echo e(auth()->user()->profile_photo ? asset('storage/'.auth()->user()->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=random'); ?>" alt="<?php echo e(auth()->user()->name); ?> avatar">
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-6">
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
                <div class="bg-white shadow-md rounded-lg p-6">
                    <form action="<?php echo e(route('admin.drivers.update', $driver->id)); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <div class="form-grid">
                            <!-- Personal Information -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-semibold text-gray-800">Personal Information</h3>
                                
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name *</label>
                                    <input type="text" name="name" id="name" value="<?php echo e(old('name', $driver->name)); ?>" required
                                           class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                           placeholder="e.g., John Doe" pattern="[A-Za-z\s]{2,50}" title="Name should be 2-50 characters long and contain only letters and spaces">
                                    <p class="text-xs text-gray-500 mt-1">Enter full name (2-50 characters, letters and spaces only).</p>
                                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                    <?php endif; ?>
                                </div>
                                
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                                    <input type="email" name="email" id="email" value="<?php echo e(old('email', $driver->email)); ?>" required
                                           class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                           placeholder="e.g., john@example.com">
                                    <p class="text-xs text-gray-500 mt-1">Enter a valid email address.</p>
                                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                    <?php endif; ?>
                                </div>
                                
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone *</label>
                                    <input type="tel" name="phone" id="phone" value="<?php echo e(old('phone', $driver->phone)); ?>" required
                                           class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                           placeholder="e.g., 0771234567 or +94771234567" pattern="(\+94|0)[0-9]{9}" title="Phone number should start with +94 or 0 followed by 9 digits">
                                    <p class="text-xs text-gray-500 mt-1">Enter a valid Sri Lankan phone number (e.g., 0771234567 or +94771234567).</p>
                                    <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                    <?php endif; ?>
                                </div>
                                
                                <div>
                                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                                    <textarea name="address" id="address" rows="3"
                                              class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                              placeholder="e.g., No. 123, Colombo Road, Colombo 03"><?php echo e(old('address', $driver->address)); ?></textarea>
                                    <p class="text-xs text-gray-500 mt-1">Enter the driver's address (optional, max 255 characters).</p>
                                    <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <!-- Driver Information -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-semibold text-gray-800">Driver Information</h3>
                                
                                <div>
                                    <label for="license_number" class="block text-sm font-medium text-gray-700">License Number *</label>
                                    <input type="text" name="license_number" id="license_number" value="<?php echo e(old('license_number', $driver->license_number)); ?>" required
                                           class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                           placeholder="e.g., B123456" pattern="[A-Za-z0-9]{5,15}" title="License number should be 5-15 alphanumeric characters">
                                    <p class="text-xs text-gray-500 mt-1">Enter a valid license number (5-15 alphanumeric characters).</p>
                                    <?php $__errorArgs = ['license_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                    <?php endif; ?>
                                </div>
                                
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700">New Password (leave blank to keep current)</label>
                                    <input type="password" name="password" id="password"
                                           class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                           placeholder="Enter new password" minlength="8" title="Password must be at least 8 characters long">
                                    <p class="text-xs text-gray-500 mt-1">Password must be at least 8 characters long (optional).</p>
                                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                    <?php endif; ?>
                                </div>
                                
                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                           class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                           placeholder="Confirm new password" minlength="8" title="Password confirmation must match the password">
                                    <p class="text-xs text-gray-500 mt-1">Must match the password above (optional).</p>
                                    <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                    <?php endif; ?>
                                </div>
                                
                                <div>
                                    <label for="driver_photo" class="block text-sm font-medium text-gray-700">Driver Photo</label>
                                    <div class="mt-1">
                                        <div id="fileUploadContainer" class="flex flex-col items-center p-5 border-2 border-dashed border-gray-300 rounded-lg bg-gray-50 cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition duration-200">
                                            <i class="fas fa-cloud-upload-alt text-3xl text-blue-500 mb-2"></i>
                                            <p class="text-sm text-gray-600">Click to upload or drag and drop</p>
                                            <p class="text-xs text-gray-500 mt-1">PNG, JPG, JPEG up to 2MB</p>
                                            <input type="file" name="driver_photo" id="driver_photo" accept="image/png,image/jpeg,image/jpg" class="hidden">
                                            <img id="imagePreview" class="file-upload-preview">
                                        </div>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Upload a clear photo of the driver (optional, max 2MB, PNG/JPG/JPEG).</p>
                                    <?php if($driver->driver_photo): ?>
                                        <div class="mt-2">
                                            <img src="<?php echo e(asset('storage/'.$driver->driver_photo)); ?>" alt="Current driver photo" class="h-20 w-20 rounded-full object-cover">
                                        </div>
                                    <?php endif; ?>
                                    <?php $__errorArgs = ['driver_photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                    <?php endif; ?>
                                </div>

                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700">Status *</label>
                                    <div class="mt-1 flex items-center space-x-4">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="status" value="active" class="form-radio h-4 w-4 text-blue-600" <?php echo e(old('status', $driver->status) == 'active' ? 'checked' : ''); ?> required>
                                            <span class="ml-2 text-sm text-gray-600">Active</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="status" value="inactive" class="form-radio h-4 w-4 text-blue-600" <?php echo e(old('status', $driver->status) == 'inactive' ? 'checked' : ''); ?>>
                                            <span class="ml-2 text-sm text-gray-600">Inactive</span>
                                        </label>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Select the driver's status.</p>
                                    <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="<?php echo e(route('admin.drivers.index')); ?>" class="bg-white py-2 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200 hover:scale-105">
                                Update Driver
                            </button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Image upload preview and validation
        const fileInput = document.getElementById('driver_photo');
        const fileUploadContainer = document.getElementById('fileUploadContainer');
        const imagePreview = document.getElementById('imagePreview');

        fileUploadContainer.addEventListener('click', function() {
            fileInput.click();
        });

        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validate file size (2MB limit)
                if (file.size > 2 * 1024 * 1024) {
                    alert('File size exceeds 2MB. Please upload a smaller file.');
                    fileInput.value = '';
                    imagePreview.style.display = 'none';
                    return;
                }
                // Preview the image
                const reader = new FileReader();
                reader.onload = function(event) {
                    imagePreview.src = event.target.result;
                    imagePreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });

        // Drag and drop functionality
        fileUploadContainer.addEventListener('dragover', (e) => {
            e.preventDefault();
            fileUploadContainer.classList.add('border-blue-500', 'bg-blue-50');
        });

        fileUploadContainer.addEventListener('dragleave', () => {
            fileUploadContainer.classList.remove('border-blue-500', 'bg-blue-50');
        });

        fileUploadContainer.addEventListener('drop', (e) => {
            e.preventDefault();
            fileUploadContainer.classList.remove('border-blue-500', 'bg-blue-50');
            
            if (e.dataTransfer.files.length) {
                fileInput.files = e.dataTransfer.files;
                const file = e.dataTransfer.files[0];
                // Validate file size (2MB limit)
                if (file.size > 2 * 1024 * 1024) {
                    alert('File size exceeds 2MB. Please upload a smaller file.');
                    fileInput.value = '';
                    imagePreview.style.display = 'none';
                    return;
                }
                // Preview the image
                const reader = new FileReader();
                reader.onload = function(event) {
                    imagePreview.src = event.target.result;
                    imagePreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html><?php /**PATH C:\Users\Dell\Desktop\sritravel\sritravel\resources\views/admin/drivers/edit.blade.php ENDPATH**/ ?>