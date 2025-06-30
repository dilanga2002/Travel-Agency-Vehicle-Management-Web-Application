<?php 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\DriverProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\VehicleController as AdminVehicleController;
use App\Http\Controllers\Admin\DriverController as AdminDriverController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\DriverMiddleware;
use App\Http\Controllers\CustomerProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;

Route::redirect('/', '/home');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/about', function () {
    return view('about');
})->name('about');
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
 Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
Route::get('/vehicles/{id}', [VehicleController::class, 'show'])->name('vehicles.show');


// Main dashboard route with strict role checking
Route::get('/dashboard', function () {
    $user = auth()->user();
    
    // Strict role checking with fallback logging
    if ($user->role === 'admin' || $user->is_admin === 1) {
        return redirect()->route('admin.dashboard');
    }
    
    if ($user->role === 'driver' || $user->is_driver === 1) {
        return redirect()->route('driver.dashboard');
    }
    
    // Only regular customers reach this point
    return app(DashboardController::class)->index();
})->middleware(['auth', 'verified'])->name('dashboard');

// Customer routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Profile routes
    Route::get('/profile', [CustomerProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [CustomerProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [CustomerProfileController::class, 'destroy'])->name('profile.destroy');
    // Vehicle and booking routes
   // Route::resource('vehicles', VehicleController::class)->only(['index', 'show']);
    Route::resource('bookings', BookingController::class); // Include all methods, no exclusions
    Route::patch('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy'); // Delete route
    Route::post('/bookings/check-driver-availability', [BookingController::class, 'checkDriverAvailability'])->name('bookings.check-driver-availability');
   
});

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', AdminMiddleware::class])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('vehicles', AdminVehicleController::class);
    Route::resource('drivers', AdminDriverController::class);
    Route::patch('vehicles/{vehicle}/toggle-availability', [VehicleController::class, 'toggleAvailability'])->name('admin.vehicles.toggle-availability');
    // Booking management
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [AdminBookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{booking}/confirm', [AdminBookingController::class, 'confirm'])->name('bookings.confirm');
    Route::post('/bookings/{booking}/cancel', [AdminBookingController::class, 'cancel'])->name('bookings.cancel');
    Route::post('/bookings/{booking}/complete', [AdminBookingController::class, 'complete'])->name('bookings.complete');
    
    // Reports
    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::post('/reports/generate', [AdminReportController::class, 'generate'])->name('reports.generate');
    Route::get('/reports/{report}/download', [AdminReportController::class, 'download'])->name('reports.download');
    Route::delete('/reports/{report}', [AdminReportController::class, 'destroy'])->name('reports.destroy');

        // Profile routes
    Route::get('/profile', [AdminProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');

    Route::get('customers', [\App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('customers.index');
    Route::get('customers/{user}', [\App\Http\Controllers\Admin\CustomerController::class, 'show'])->name('customers.show');
    Route::delete('customers/{user}', [\App\Http\Controllers\Admin\CustomerController::class, 'destroy'])->name('customers.destroy');
});

// Driver routes
Route::prefix('driver')->name('driver.')->middleware(['auth', 'verified', DriverMiddleware::class])->group(function () {
    Route::get('/dashboard', [DriverController::class, 'dashboard'])->name('dashboard');
    Route::get('/bookings', [DriverController::class, 'bookings'])->name('bookings.index');
    Route::get('/bookings/{booking}', [DriverController::class, 'showBooking'])->name('bookings.show');
    
    // Driver profile
  Route::get('/profile/edit', [DriverProfileController::class, 'show'])->name('profile.edit');
    Route::put('/profile', [DriverProfileController::class, 'update'])->name('profile.update');
});

require __DIR__.'/auth.php';