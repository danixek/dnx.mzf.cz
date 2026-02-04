<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\ErrorController;
use Illuminate\Support\Facades\Route;

// Home routes
Route::get('/', [HomeController::class, 'index']);
Route::get('/detail', [HomeController::class, 'detail'])->name('detail');
Route::get('/library', [HomeController::class, 'library'])->name('library');
Route::get('/blog', [BlogController::class, 'index'])->name('blog');

// Dashboard route
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::post('/dashboard', [DashboardController::class, 'saveSettings'])
    ->middleware('auth')
    ->name('dashboard.save-settings');
    
// Auth routes
Route::middleware('web')->group(function() {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Google OAuth routes
Route::get('/auth/google', [SocialAuthController::class, 'redirectGoogle'])
    ->name('google.login');
Route::get('/auth/google/callback', [SocialAuthController::class, 'callbackGoogle'])
    ->name('google.callback');

// Error handling route
Route::get('/error/{code?}', [ErrorController::class, 'show'])
    ->where('code', '[0-9]+')
    ->name('error.show');;

// require __DIR__.'/settings.php';
?>