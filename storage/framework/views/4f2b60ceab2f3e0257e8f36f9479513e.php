<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="<?php echo e(asset('images/favicon-32x32.png')); ?>">
    <title>SriTravel - Admin Profile</title>
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

        /* Form field styles */
        .form-field {
            width: 100%;
            max-width: 500px; /* Consistent width for all fields */
        }

        .form-field input,
        .form-field textarea {
            height: 42px; /* Uniform height for inputs */
            padding: 0 12px;
            border-radius: 6px;
            border: 1px solid #d1d5db;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-field textarea {
            height: 100px; /* Specific height for textarea */
            padding: 12px;
            resize: vertical;
        }

        .form-field input:focus,
        .form-field textarea:focus {
            border-color: #3B82F6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            outline: none;
        }

        .form-field label {
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 6px;
            display: block;
        }

        /* Button styles */
        .btn-primary {
            padding: 10px 20px;
            border-radius: 6px;
            background-color: #3B82F6;
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            transition: background-color 0.2s, transform 0.1s;
        }

        .btn-primary:hover {
            background-color: #2563EB;
            transform: translateY(-1px);
        }

        .btn-primary:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
            outline: none;
        }

        /* File input styling */
        .custom-file-input {
            display: flex;
            align-items: center;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            height: 42px; /* Match other input heights */
            background-color: #f9fafb;
            overflow: hidden;
        }

        .custom-file-input input[type="file"] {
            display: none; /* Hide default file input */
        }

        .custom-file-input label {
            background-color: #3B82F6;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.875rem;
            font-weight: 500;
            margin: 0;
            height: 100%;
            display: flex;
            align-items: center;
            transition: background-color 0.2s;
        }

        .custom-file-input label:hover {
            background-color: #2563EB;
        }

        .custom-file-input span {
            flex: 1;
            padding: 0 12px;
            font-size: 0.875rem;
            color: #6b7280;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
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
            .form-field {
                max-width: 100%;
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
                <p class="text-sm text-blue-200">Admin Panel</p>
            </div>
            
            <div class="p-4 border-b border-blue-800 flex items-center">
                <img class="h-10 w-10 rounded-full mr-3" src="<?php echo e($user->profile_photo ? asset('storage/'.$user->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random'); ?>" alt="User avatar">
                <div>
                    <p class="font-medium"><?php echo e($user->name); ?></p>
                    <p class="text-blue-200 text-xs"><?php echo e($user->email); ?></p>
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
                        <a href="<?php echo e(route('admin.profile.show')); ?>" class="text-white bg-blue-700 border-l-4 border-blue-400 flex items-center">
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
                <div>
                    <h1 class="text-2xl font-semibold font-heading text-gray-800">Admin Profile</h1>
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <a href="<?php echo e(route('admin.dashboard')); ?>" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                                    <i class="fas fa-home mr-2"></i>
                                    Home
                                </a>
                            </li>
                            <li aria-current="page">
                                <div class="flex items-center">
                                    <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Profile</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600 hidden md:inline">
                        Last login: <?php echo e($user->last_login_at ? $user->last_login_at->diffForHumans() : 'First time login'); ?>

                    </span>
                    <div class="relative">
                        <button id="notificationBtn" class="p-1 text-gray-500 hover:text-blue-600">
                            <i class="fas fa-bell"></i>
                            <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500"></span>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-6 bg-white rounded-xl shadow">
                <?php if(session('success')): ?>
                    <div id="success-message" class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg" role="alert">
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>
                <?php if(session('error')): ?>
                    <div id="error-message" class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg" role="alert">
                        <?php echo e(session('error')); ?>

                    </div>
                <?php endif; ?>

                <div class="max-w-2xl mx-auto">
                    <!-- Profile Information -->
                    <section class="mb-12">
                        <header>
                            <h2 class="text-lg font-semibold text-gray-900">Profile Information</h2>
                            <p class="mt-1 text-sm text-gray-600">Update your account's profile information, email address, and photo.</p>
                        </header>

                        <form action="<?php echo e(route('admin.profile.update')); ?>" method="POST" enctype="multipart/form-data" class="mt-6 space-y-6">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>

                            <!-- Profile Photo -->
                            <div class="form-field">
                                <label class="block">Profile Photo</label>
                                <div class="flex items-center">
                                    <img class="h-16 w-16 rounded-full object-cover" src="<?php echo e($user->profile_photo ? asset('storage/'.$user->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random'); ?>" alt="<?php echo e($user->name); ?>">
                                    <div class="ml-4 flex-1">
                                        <div class="custom-file-input">
                                            <input type="file" name="profile_photo" id="profile_photo" accept="image/*">
                                            <label for="profile_photo">Choose File</label>
                                            <span id="file-name">No file chosen</span>
                                        </div>
                                        <?php $__errorArgs = ['profile_photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Name -->
                            <div class="form-field">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" value="<?php echo e(old('name', $user->name)); ?>" class="w-full">
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Email -->
                            <div class="form-field">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" value="<?php echo e(old('email', $user->email)); ?>" class="w-full">
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Phone -->
                            <div class="form-field">
                                <label for="phone">Phone</label>
                                <input type="text" name="phone" id="phone" value="<?php echo e(old('phone', $user->phone)); ?>" class="w-full">
                                <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Address -->
                            <div class="form-field">
                                <label for="address">Address</label>
                                <textarea name="address" id="address" class="w-full"><?php echo e(old('address', $user->address)); ?></textarea>
                                <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div>
                                <button type="submit" class="btn-primary">
                                    <i class="fas fa-save mr-2"></i> Save Changes
                                </button>
                            </div>
                        </form>
                    </section>

                    <!-- Password Update -->
                    <section>
                        <header>
                            <h2 class="text-lg font-semibold text-gray-900">Update Password</h2>
                            <p class="mt-1 text-sm text-gray-600">Ensure your account is using a long, random password to stay secure.</p>
                        </header>

                        <form action="<?php echo e(route('admin.profile.update')); ?>" method="POST" class="mt-6 space-y-6">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>

                            <!-- Current Password -->
                            <div class="form-field">
                                <label for="current_password">Current Password</label>
                                <input type="password" name="current_password" id="current_password" class="w-full" autocomplete="current-password">
                                <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- New Password -->
                            <div class="form-field">
                                <label for="password">New Password</label>
                                <input type="password" name="password" id="password" class="w-full" autocomplete="new-password">
                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Confirm Password -->
                            <div class="form-field">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="w-full" autocomplete="new-password">
                                <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div>
                                <button type="submit" class="btn-primary">
                                    <i class="fas fa-save mr-2"></i> Save Password
                                </button>
                            </div>
                        </form>
                    </section>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Auto-hide success/error messages
        document.addEventListener('DOMContentLoaded', function () {
            const successMessage = document.getElementById('success-message');
            const errorMessage = document.getElementById('error-message');
            if (successMessage || errorMessage) {
                setTimeout(() => {
                    [successMessage, errorMessage].forEach(message => {
                        if (message) {
                            message.style.transition = 'opacity 0.5s ease';
                            message.style.opacity = '0';
                            setTimeout(() => message.remove(), 500);
                        }
                    });
                }, 4500);
            }

            // File input name display
            const fileInput = document.getElementById('profile_photo');
            const fileNameDisplay = document.getElementById('file-name');
            fileInput.addEventListener('change', function () {
                fileNameDisplay.textContent = this.files.length > 0 ? this.files[0].name : 'No file chosen';
            });
        });
    </script>
</body>
</html><?php /**PATH D:\fproject\project\project\sritravel\sritravel\resources\views/admin/profile/show.blade.php ENDPATH**/ ?>