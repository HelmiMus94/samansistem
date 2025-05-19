<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SummonController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ViolationController;
use App\Http\Controllers\ProfileController; // Ensure this line is present or add it
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
// Note: The Auth\PasswordController was in your original file uploads but not in the routes content you pasted.
// If you use it for password updates initiated from the profile, ensure its route is also correctly defined.

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Authentication routes (guest)
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

// Authentication routes (auth)
Route::middleware('auth')->group(function () {
    Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])
        ->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');
    // This route was 'put' in your original file, but 'password.update' is often a POST or PATCH.
    // Laravel Breeze typically uses PATCH for profile password updates via ProfileController,
    // and PUT for the dedicated password update form (PasswordController).
    // The route name 'password.update' is also used by Breeze for PasswordController.
    // Ensure this doesn't conflict if you have a separate PasswordController route.
    // For now, assuming this is for the confirmable password flow.
    Route::post('password', [ConfirmablePasswordController::class, 'store']); // Changed from put to post as store is used.

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

// Public home page
Route::get('/', function () {
    return view('welcome');
});

// Protected routes that require authentication
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ***** ADD THESE PROFILE ROUTES *****
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // ***********************************

    // Customer routes
    Route::resource('customers', CustomerController::class);

    // Summons routes
    Route::resource('summons', SummonController::class);

    // Payment routes
    Route::resource('payments', PaymentController::class);

    // Violation types routes
    Route::resource('violations', ViolationController::class);

    // User management (example, adjust middleware as needed)
    // Route::middleware(['can:manage-users'])->group(function () { // Assuming you have a 'manage-users' gate/policy
    Route::resource('users', UserController::class);
    // });

    // Reports (example, adjust middleware as needed)
    // Route::middleware(['can:view-reports'])->group(function () { // Assuming you have a 'view-reports' gate/policy
    Route::get('/reports/summons', [ReportController::class, 'summons'])->name('reports.summons');
    Route::get('/reports/payments', [ReportController::class, 'payments'])->name('reports.payments');
    // });
});
