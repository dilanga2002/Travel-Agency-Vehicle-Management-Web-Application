<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon-32x32.png') }}">
    <title>SriTravel - Driver Dashboard</title>
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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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

        .status-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-confirmed {
            background-color: #D1FAE5;
            color: #065F46;
        }

        .status-pending {
            background-color: #FEF3C7;
            color: #92400E;
        }

        .status-cancelled {
            background-color: #FEE2E2;
            color: #991B1B;
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
<body class="font-sans bg-gray-50">
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar bg-blue-900 text-white">
            <div class="sidebar-header">
                <h2 class="text-xl font-bold font-heading flex items-center">
                    <i class="fas fa-car text-blue-400 mr-2"></i>
                    SriTravel
                </h2>
                <p class="text-sm text-blue-200">Driver Panel</p>
            </div>
            
            <div class="p-4 border-b border-blue-800 flex items-center">
                <img class="h-10 w-10 rounded-full mr-3" src="{{ auth()->user()->profile_photo ? asset('storage/'.auth()->user()->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=random' }}" alt="Driver photo">
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
                        <a href="{{ route('driver.dashboard') }}" class="text-white bg-blue-700 border-l-4 border-blue-400 flex items-center">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('driver.bookings.index') }}" class="text-blue-200 hover:text-white hover:bg-blue-700 flex items-center">
                            <i class="fas fa-calendar-check"></i> My Assignments
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('driver.profile.edit') }}" class="text-blue-200 hover:text-white hover:bg-blue-700 flex items-center">
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

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <header class="bg-white shadow-md rounded-lg p-4 flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold font-heading text-gray-800">Driver Dashboard</h2>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600 hidden md:inline">Last login: {{ auth()->user()->last_login_at?->diffForHumans() ?? 'First time login' }}</span>
                    <div class="relative">
                        <button id="notificationBtn" class="p-1 text-gray-500 hover:text-blue-600">
                            <i class="fas fa-bell"></i>
                            <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500"></span>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-6">
                <!-- Welcome Banner -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-xl p-6 mb-6 shadow-md transition duration-300 hover:scale-105">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-car text-4xl opacity-20"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-2xl font-bold">Welcome back, {{ auth()->user()->name }}!</h3>
                            <p class="mt-1 text-blue-100">You have {{ $todayAssignments }} assignments today</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="dashboard-card bg-white shadow rounded-xl p-6 transition duration-300 hover:scale-105">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Today's Assignments</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $todayAssignments }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="dashboard-card bg-white shadow rounded-xl p-6 transition duration-300 hover:scale-105">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                                <i class="fas fa-check-double"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Completed Trips</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $completedTrips }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upcoming Assignments -->
                <div class="bg-white shadow rounded-xl p-6 mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-800">Upcoming Assignments</h3>
                        <a href="{{ route('driver.bookings.index') }}" class="text-sm text-blue-600 hover:text-blue-800 flex items-center">
                            View All <i class="fas fa-chevron-right ml-1 text-xs"></i>
                        </a>
                    </div>
                    
                    @if($upcomingAssignments->isEmpty())
                        <div class="text-center py-8">
                            <i class="fas fa-calendar-times text-4xl text-gray-300 mb-3"></i>
                            <p class="text-gray-500">You don't have any upcoming assignments</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vehicle</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trip Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pickup Location</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($upcomingAssignments as $booking)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ $booking->user->profile_photo ? asset('storage/'.$booking->user->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode($booking->user->name) . '&background=random' }}" alt="{{ $booking->user->name }}">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $booking->user->name }}</div>
                                                    <div class="text-sm text-gray-500">{{ $booking->user->phone }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $booking->vehicle->make }} {{ $booking->vehicle->model }}</div>
                                            <div class="text-sm text-gray-500">{{ $booking->vehicle->registration_number }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $booking->start_date->format('M d, Y') }}</div>
                                            <div class="text-sm text-gray-500">{{ $booking->total_days }} day(s)</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $booking->pickup_location }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($booking->status == 'confirmed')
                                                <span class="status-badge status-confirmed">
                                                    <i class="fas fa-check-circle mr-1"></i> Confirmed
                                                </span>
                                            @elseif($booking->status == 'pending')
                                                <span class="status-badge status-pending">
                                                    <i class="fas fa-clock mr-1"></i> Pending
                                                </span>
                                            @else
                                                <span class="status-badge status-cancelled">
                                                    <i class="fas fa-times-circle mr-1"></i> Cancelled
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('driver.bookings.show', $booking->id) }}" class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                <i class="fas fa-eye mr-1"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                <!-- Recent Activity -->
                <div class="bg-white shadow rounded-xl p-6">
                    <h3 class="text-lg font-medium text-gray-800 mb-4">Recent Activity</h3>
                    <div class="space-y-4">
                        @forelse($recentActivities as $booking)
                            <div class="flex items-start">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-3">
                                    <i class="fas fa-car"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">You completed a trip for {{ $booking->user->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $booking->vehicle->make }} {{ $booking->vehicle->model }} - {{ $booking->updated_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">No recent activity</p>
                        @endforelse
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>