<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon-32x32.png') }}">
    <title>SriTravel - Book Vehicle</title>
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

        .form-input {
            transition: all 0.3s;
            border: 2px solid #D1D5DB !important;
        }
        .form-input:focus {
            border-color: #3B82F6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }
        .error-message {
            color: #EF4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body class="font-sans bg-gray-50">
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
                        <a href="{{ route('vehicles.index') }}" class="text-blue-200 hover:text-white hover:bg-blue-700 flex items-center">
                            <i class="fas fa-car"></i> Browse Vehicles
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('bookings.index') }}" class="text-white bg-blue-700 border-l-4 border-blue-400 flex items-center">
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
            <header class="bg-white shadow-md rounded-lg p-4 flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-semibold font-heading text-gray-800">Book Vehicle</h1>
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                                    <i class="fas fa-home mr-2"></i> Home
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
                                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Book Vehicle</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                </div>
                <a href="{{ route('vehicles.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-200 active:bg-gray-300 focus:outline-none focus:border-gray-300 focus:ring focus:ring-gray-200 disabled:opacity-25 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Vehicles
                </a>
            </header>

            <main>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2">
                        <div class="bg-white shadow rounded-xl p-6">
                            <h2 class="text-lg font-medium text-gray-800 mb-6">Booking Details</h2>
                            <form action="{{ route('bookings.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                                <input type="hidden" name="vehicle_id" value="{{ request()->get('vehicle_id') }}">
                                <input type="hidden" name="price_per_km" value="{{ request()->get('price_per_km') }}">
                                <input type="hidden" name="status" value="pending">
                                <input type="hidden" name="created_at" value="{{ now() }}">
                                <input type="hidden" name="updated_at" value="{{ now() }}">

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                                        <input type="date" name="start_date" id="start_date" min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                               class="form-input w-full h-10 rounded-md shadow-sm px-3 @error('start_date') border-red-500 @enderror" value="{{ old('start_date') }}" required>
                                        @error('start_date')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                                        <input type="date" name="end_date" id="end_date"
                                               class="form-input w-full h-10 rounded-md shadow-sm px-3 @error('end_date') border-red-500 @enderror" value="{{ old('end_date') }}" required>
                                        @error('end_date')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="pickup_time" class="block text-sm font-medium text-gray-700 mb-1">Pickup Time</label>
                                        <input type="time" name="pickup_time" id="pickup_time"
                                               class="form-input w-full h-10 rounded-md shadow-sm px-3 @error('pickup_time') border-red-500 @enderror" value="{{ old('pickup_time') }}" required>
                                        @error('pickup_time')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="pickup_location" class="block text-sm font-medium text-gray-700 mb-1">Pickup Location</label>
                                        <input type="text" name="pickup_location" id="pickup_location"
                                               class="form-input w-full h-10 rounded-md shadow-sm px-3 @error('pickup_location') border-red-500 @enderror" value="{{ old('pickup_location') }}" required>
                                        @error('pickup_location')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="dropoff_location" class="block text-sm font-medium text-gray-700 mb-1">Dropoff Location</label>
                                        <input type="text" name="dropoff_location" id="dropoff_location"
                                               class="form-input w-full h-10 rounded-md shadow-sm px-3 @error('dropoff_location') border-red-500 @enderror" value="{{ old('dropoff_location') }}" required>
                                        @error('dropoff_location')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="destination" class="block text-sm font-medium text-gray-700 mb-1">Destination</label>
                                        <input type="text" name="destination" id="destination"
                                               class="form-input w-full h-10 rounded-md shadow-sm px-3 @error('destination') border-red-500 @enderror" value="{{ old('destination') }}" required>
                                        @error('destination')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="driver_id" class="block text-sm font-medium text-gray-700 mb-1">Select Driver (Optional)</label>
                                        <select name="driver_id" id="driver_id" class="form-input w-full h-10 rounded-md shadow-sm px-3 @error('driver_id') border-red-500 @enderror">
                                            <option value="">No Driver</option>
                                            @foreach($drivers as $driver)
                                                <option value="{{ $driver->id }}" {{ old('driver_id') == $driver->id ? 'selected' : '' }} data-available="true">{{ $driver->name }} ({{ $driver->license_number }})</option>
                                            @endforeach
                                        </select>
                                        <p id="driver-availability" class="text-sm text-gray-600 mt-2"></p>
                                        @error('driver_id')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="total_KiloMeter" class="block text-sm font-medium text-gray-700 mb-1">Total Kilometers</label>
                                        <input type="number" name="total_KiloMeter" id="total_KiloMeter" min="1"
                                               class="form-input w-full h-10 rounded-md shadow-sm px-3 @error('total_KiloMeter') border-red-500 @enderror" value="{{ old('total_KiloMeter') }}" required>
                                        @error('total_KiloMeter')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="md:col-span-2">
                                        <label for="special_requests" class="block text-sm font-medium text-gray-700 mb-1">Special Requests</label>
                                        <textarea name="special_requests" id="special_requests" rows="4"
                                                  class="form-input w-full rounded-md shadow-sm px-3 py-2 @error('special_requests') border-red-500 @enderror"
                                                  placeholder="Any special requirements or notes...">{{ old('special_requests') }}</textarea>
                                        @error('special_requests')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="md:col-span-2 pt-4 border-t border-gray-200">
                                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-300 hover:scale-105">
                                            <i class="fas fa-calendar-check mr-2"></i> Confirm Booking
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div>
                        <div class="bg-white shadow rounded-xl p-6 sticky top-6">
                            <h2 class="text-lg font-medium text-gray-800 mb-4">Booking Summary</h2>
                            <div class="space-y-4">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Per KM Rate:</span>
                                    <span class="font-medium" id="summary-rate">Rs. {{ number_format(request()->get('price_per_km', 0), 2) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Rental Period (Days):</span>
                                    <span class="font-medium" id="summary-days">0 days</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Total Kilometers:</span>
                                    <span class="font-medium" id="summary-km">0 km</span>
                                </div>
                                <div class="border-t border-gray-200 pt-4 mt-4">
                                    <div class="flex justify-between font-bold text-lg">
                                        <span>Total Amount:</span>
                                        <span id="summary-total">Rs. 0.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        async function updateDriverAvailability() {
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;
            const driverSelect = document.getElementById('driver_id');
            const availabilityText = document.getElementById('driver-availability');

            if (!startDate || !endDate) {
                availabilityText.textContent = 'Please select both start and end dates to check driver availability.';
                return;
            }

            try {
                const response = await fetch('{{ route('bookings.check-driver-availability') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ start_date: startDate, end_date: endDate })
                });

                const data = await response.json();
                
                // Reset all options
                Array.from(driverSelect.options).forEach(option => {
                    if (option.value !== '') {
                        option.dataset.available = 'false';
                        option.textContent = option.textContent.replace(' (Available)', '').replace(' (Unavailable)', '');
                    }
                });

                // Update availability
                data.drivers.forEach(driver => {
                    const option = driverSelect.querySelector(`option[value="${driver.id}"]`);
                    if (option) {
                        option.dataset.available = driver.is_available;
                        option.textContent = `${driver.name} (${driver.license_number})${driver.is_available ? ' (Available)' : ' (Unavailable)'}`;
                        if (!driver.is_available) {
                            option.disabled = true;
                        } else {
                            option.disabled = false;
                        }
                    }
                });

                availabilityText.textContent = 'Driver availability updated based on selected dates.';
            } catch (error) {
                console.error('Error checking driver availability:', error);
                availabilityText.textContent = 'Error checking driver availability. Please try again.';
            }
        }

        function updateBookingSummary() {
            const startDate = new Date(document.getElementById('start_date').value);
            const endDate = new Date(document.getElementById('end_date').value);
            const km = parseInt(document.getElementById('total_KiloMeter').value) || 0;
            const pricePerKm = parseFloat(document.querySelector('input[name="price_per_km"]').value) || 0;

            let days = 0;
            if (startDate && endDate && startDate <= endDate) {
                const diffTime = Math.abs(endDate - startDate);
                days = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
            }

            const totalAmount = days * km * pricePerKm;

            document.getElementById('summary-days').textContent = `${days} days`;
            document.getElementById('summary-km').textContent = `${km} km`;
            document.getElementById('summary-total').textContent = `Rs. ${totalAmount.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
        }

        document.getElementById('start_date').addEventListener('change', () => {
            updateBookingSummary();
            updateDriverAvailability();
        });
        document.getElementById('end_date').addEventListener('change', () => {
            updateBookingSummary();
            updateDriverAvailability();
        });
        document.getElementById('total_KiloMeter').addEventListener('input', updateBookingSummary);

        document.getElementById('start_date').addEventListener('change', function() {
            const startDate = this.value;
            const endDateInput = document.getElementById('end_date');
            if (startDate) {
                endDateInput.min = startDate;
                if (endDateInput.value && endDateInput.value < startDate) {
                    endDateInput.value = startDate;
                }
            }
        });

        const today = new Date();
        const tomorrow = new Date(today);
        tomorrow.setDate(tomorrow.getDate() + 1);
        document.getElementById('start_date').min = tomorrow.toISOString().split('T')[0];
    </script>
</body>
</html>