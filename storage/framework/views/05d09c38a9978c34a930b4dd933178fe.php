<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="<?php echo e(asset('images/favicon-32x32.png')); ?>">
    <title>SriTravel - Admin Reports</title>
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

        .card-icon {
            width: 3rem;
            height: 3rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .error-message {
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: 0.25rem;
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
        <div class="sidebar">
            <div class="sidebar-header">
                <h2 class="text-xl font-bold font-heading flex items-center">
                    <i class="fas fa-car text-accent-500 mr-2"></i>
                    SriTravel
                </h2>
                <p class="text-sm text-primary-200">Admin Panel</p>
            </div>

            <div class="p-4 border-b border-primary-800 flex items-center">
                <img class="h-10 w-10 rounded-full mr-3" src="<?php echo e(auth()->user()->profile_photo ? asset('storage/'.auth()->user()->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=random'); ?>" alt="<?php echo e(auth()->user()->name); ?> avatar">
                <div>
                    <p class="font-medium"><?php echo e(auth()->user()->name); ?></p>
                    <p class="text-primary-200 text-xs"><?php echo e(auth()->user()->email); ?></p>
                </div>
            </div>

            <div class="sidebar-menu">
                <ul>
                    <li>
                        <a href="/" class="flex items-center">
                            <i class="fas fa-home"></i> Home
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('admin.vehicles.index')); ?>" class="flex items-center">
                            <i class="fas fa-car"></i> Vehicles
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('admin.drivers.index')); ?>" class="flex items-center">
                            <i class="fas fa-users"></i> Drivers
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('admin.bookings.index')); ?>" class="flex items-center">
                            <i class="fas fa-calendar-check"></i> Bookings
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('admin.customers.index')); ?>" class="text-blue-200 hover:text-white hover:bg-blue-700 flex items-center">
                            <i class="fas fa-users"></i> Customers
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('admin.reports.index')); ?>" class="text-white bg-primary-700 border-l-4 border-accent-500 flex items-center">
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
                <h1 class="text-2xl font-semibold font-heading text-gray-800">Reports</h1>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600 hidden md:inline">Last login: <?php echo e(auth()->user()->last_login_at?->diffForHumans() ?? 'First time login'); ?></span>
                    <div class="relative">
                        <button id="notificationBtn" class="p-1 text-gray-500 hover:text-primary-600">
                            <i class="fas fa-bell"></i>
                            <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500"></span>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Success/Error Messages -->
            <?php if(session('success')): ?>
                <div id="success-message" class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg" role="alert">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg" role="alert">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>

            <!-- Main Content Area -->
            <main class="p-6 bg-white rounded-xl shadow">
                <!-- Generate Report Form -->
                <div class="mb-8">
                    <div class="content-header flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                        <div class="mb-4 md:mb-0">
                            <h2 class="text-lg font-medium text-gray-800">Generate New Report</h2>
                            <p class="text-sm text-gray-500">Create a new bookings or vehicle usage report</p>
                        </div>
                    </div>

                    <form action="<?php echo e(route('admin.reports.generate')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="report_type" class="block text-sm font-medium text-gray-700">Report Type</label>
                                <select id="report_type" name="report_type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-lg">
                                    <option value="bookings" <?php echo e(old('report_type') == 'bookings' ? 'selected' : ''); ?>>Bookings Report</option>
                                    <option value="vehicle_usage" <?php echo e(old('report_type') == 'vehicle_usage' ? 'selected' : ''); ?>>Vehicle Usage Report</option>
                                </select>
                                <?php $__errorArgs = ['report_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="error-message"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                                <input type="date" name="start_date" id="start_date" value="<?php echo e(old('start_date')); ?>" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                <?php $__errorArgs = ['start_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="error-message"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                                <input type="date" name="end_date" id="end_date" value="<?php echo e(old('end_date')); ?>" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                <?php $__errorArgs = ['end_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="error-message"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        
                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition duration-200 hover:scale-105">
                                <i class="fas fa-file-pdf mr-2"></i> Generate PDF Report
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Quick Stats -->
                <div class="cards grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="card bg-white rounded-lg p-5 shadow-md hover:shadow-lg transition-transform hover:-translate-y-1">
                        <div class="card-header flex justify-between items-center mb-4">
                            <h4 class="card-title text-sm text-gray-500">Total Bookings</h4>
                            <div class="card-icon bg-blue-100 text-blue-600">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                        </div>
                        <div class="card-value text-2xl font-semibold text-gray-800"><?php echo e($totalBookings); ?></div>
                        <div class="card-footer text-xs text-gray-500">This month</div>
                    </div>
                    <div class="card bg-white rounded-lg p-5 shadow-md hover:shadow-lg transition-transform hover:-translate-y-1">
                        <div class="card-header flex justify-between items-center mb-4">
                            <h4 class="card-title text-sm text-gray-500">Vehicle Utilization</h4>
                            <div class="card-icon bg-purple-100 text-purple-600">
                                <i class="fas fa-chart-pie"></i>
                            </div>
                        </div>
                        <div class="card-value text-2xl font-semibold text-gray-800"><?php echo e($utilizationRate); ?>%</div>
                        <div class="card-footer text-xs text-gray-500">Current rate</div>
                    </div>
                </div>

                <!-- Recent Reports -->
                <div class="content-area">
                    <div class="content-header flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                        <div class="mb-4 md:mb-0">
                            <h2 class="text-lg font-medium text-gray-800">Recent Reports</h2>
                            <p class="text-sm text-gray-500">Latest generated reports</p>
                        </div>
                        <form action="<?php echo e(route('admin.reports.index')); ?>" method="GET" class="flex items-center">
                            <label for="sort" class="block text-sm font-medium text-gray-700 mr-2">Sort By</label>
                            <select id="sort" name="sort" onchange="this.form.submit()" class="mt-1 block w-32 pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-lg">
                                <option value="newest" <?php echo e(request('sort', 'newest') === 'newest' ? 'selected' : ''); ?>>Newest</option>
                                <option value="oldest" <?php echo e(request('sort', 'newest') === 'oldest' ? 'selected' : ''); ?>>Oldest</option>
                            </select>
                        </form>
                    </div>

                    <?php if($recentReports->isEmpty()): ?>
                        <div class="text-center py-12">
                            <i class="fas fa-file-alt text-4xl text-gray-300 mb-3"></i>
                            <h3 class="text-lg font-medium text-gray-700">No reports found</h3>
                            <p class="text-gray-500 mt-1">There are no recent reports to display.</p>
                        </div>
                    <?php else: ?>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Report ID</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Range</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Generated On</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php $__currentLoopData = $recentReports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            Rp-<?php echo e($report->id); ?>

                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            <?php echo e(ucfirst(str_replace('_', ' ', $report->report_type))); ?>

                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <?php echo e($report->start_date->format('M d, Y')); ?> - <?php echo e($report->end_date->format('M d, Y')); ?>

                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <?php echo e($report->created_at->format('M d, Y h:i A')); ?>

                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="<?php echo e(route('admin.reports.download', $report->id)); ?>" class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 mr-2">
                                                <i class="fas fa-download mr-1"></i> Download
                                            </a>
                                            <form action="<?php echo e(route('admin.reports.destroy', $report->id)); ?>" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this report?');">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                    <i class="fas fa-trash mr-1"></i> Delete
                                                </button>
                                            </form>
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

            const form = document.querySelector('form[action="<?php echo e(route('admin.reports.generate')); ?>"]');
            if (!form.querySelector('.error-message')) {
                form.reset();
            }
        });
    </script>
</body>
</html><?php /**PATH C:\Users\Dell\Desktop\sritravel\sritravel\resources\views/admin/reports/index.blade.php ENDPATH**/ ?>