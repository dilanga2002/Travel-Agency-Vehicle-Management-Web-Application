<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <link rel="icon" type="image/png" href="{{ asset('images/favicon-32x32.png') }}">
    <title>SriTravel - Admin Vehicle Details</title>
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
            
            <div class="sidebar-menu">
                <ul>
                    <li>
                        <a href="/" class="text-blue-200 hover:text-white hover:bg-blue-700 flex items-center">
                            <i class="fas fa-home"></i> Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="text-blue-200 hover:text-white hover:bg-blue-700 flex items-center">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.vehicles.index') }}" class="text-white bg-blue-700 border-l-4 border-blue-400 flex items-center">
                            <i class="fas fa-car"></i> Vehicles
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.drivers.index') }}" class="text-blue-200 hover:text-white hover:bg-blue-700 flex items-center">
                            <i class="fas fa-users"></i> Drivers
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.bookings.index') }}" class="text-blue-200 hover:text-white hover:bg-blue-700 flex items-center">
                            <i class="fas fa-calendar-check"></i> Bookings
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.customers.index') }}" class="text-blue-200 hover:text-white hover:bg-blue-700 flex items-center">
                            <i class="fas fa-users"></i> Customers
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.reports.index') }}" class="text-blue-200 hover:text-white hover:bg-blue-700 flex items-center">
                            <i class="fas fa-chart-bar"></i> Reports
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.profile.show') }}" class="text-white bg-blue-700 border-l-4 border-blue-400 flex items-center">
                            <i class="fas fa-user"></i> Profile
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
                <h2 class="text-xl font-semibold font-heading text-gray-800">Vehicle Details</h2>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>
                    <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=random" alt="User avatar">
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-6">
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <!-- Vehicle Header -->
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-medium text-gray-800">{{ $vehicle->make }} {{ $vehicle->model }}</h3>
                            <div class="mt-1 flex items-center">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $vehicle->available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $vehicle->available ? 'Available' : 'Not Available' }}
                                </span>
                                <span class="ml-2 text-sm text-gray-500">Registration: {{ $vehicle->registration_number }}</span>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('admin.vehicles.edit', $vehicle->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg mr-2 transition duration-200 hover:scale-105">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                            <form action="{{ route('admin.vehicles.destroy', $vehicle->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition duration-200 hover:scale-105" onclick="return confirm('Are you sure you want to delete this vehicle?')">
                                    <i class="fas fa-trash mr-1"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Vehicle Content -->
                    <div class="px-6 py-4 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Vehicle Image -->
                        <div>
                            @if($vehicle->image)
                                <img src="{{ asset('storage/'.$vehicle->image) }}" alt="{{ $vehicle->make }} {{ $vehicle->model }}" class="w-full h-96 rounded-lg shadow-md object-cover">
                            @else
                                <div class="w-full h-96 bg-gray-200 rounded-lg shadow-md flex items-center justify-center text-gray-500">
                                    <i class="fas fa-car text-5xl"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Vehicle Details -->
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Make</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ $vehicle->make }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Model</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ $vehicle->model }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Year</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ $vehicle->year }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Type</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ ucfirst($vehicle->type) }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Registration</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ $vehicle->registration_number }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Price/km</h4>
                                    <p class="mt-1 text-sm text-gray-900">Rs. {{ number_format($vehicle->price_per_km, 2) }}</p>
                                </div>
                            </div>

                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Description</h4>
                                <p class="mt-1 text-sm text-gray-900">{{ $vehicle->description ?? 'No description available' }}</p>
                            </div>

                            <!-- Availability Toggle -->
                            <div class="pt-4 border-t border-gray-200">
                                <form action="{{ route('admin.vehicles.toggle-availability', $vehicle->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="flex items-center">
                                        <span class="mr-3 text-sm font-medium text-gray-700">Availability</span>
                                        <button type="submit" class="relative inline-flex items-center h-6 rounded-full w-11 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 
                                            {{ $vehicle->available ? 'bg-blue-600' : 'bg-gray-200' }}">
                                            <span class="sr-only">Toggle availability</span>
                                            <span class="inline-block w-4 h-4 transform transition rounded-full bg-white 
                                                {{ $vehicle->available ? 'translate-x-6' : 'translate-x-1' }}"></span>
                                        </button>
                                        <span class="ml-3 text-sm font-medium text-gray-700">
                                            {{ $vehicle->available ? 'Available' : 'Not Available' }}
                                        </span>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Bookings -->
                    <div class="px-6 py-4 border-t border-gray-200">
                        <h4 class="text-md font-medium text-gray-800 mb-4">Recent Bookings</h4>
                        
                        @if($vehicle->bookings->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Booking ID</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dates</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($vehicle->bookings->sortByDesc('created_at')->take(5) as $booking)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">#BK-{{ $booking->id }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $booking->user->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $booking->user->email }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $booking->start_date->format('M d, Y') }} - {{ $booking->end_date->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                Rs. {{ number_format($booking->total_amount, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($booking->status == 'confirmed')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        Confirmed
                                                    </span>
                                                @elseif($booking->status == 'pending')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        Pending
                                                    </span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                        Cancelled
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-sm text-gray-500">No recent bookings for this vehicle.</p>
                        @endif
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>