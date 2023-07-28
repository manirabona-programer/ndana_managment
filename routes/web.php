<?php

    use Illuminate\Foundation\Application;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Route;
    use Inertia\Inertia;

    /*
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register web routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | contains the "web" middleware group. Now create something great!
    |
    */

    Route::get('/', function () {
        return Inertia::render('Auth/Login', [
            'canLogin' => Route::has('login'),
            'canRegister' => false,
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    });

    Route::get('/register', function () {
        return Inertia::render('Auth/Login', [
            'canLogin' => Route::has('login'),
            'canRegister' => false,
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    });

    Route::get('/geek/register', function () {
        return Inertia::render('Auth/Register', [
            'canLogin' => Route::has('login'),
            'canRegister' => true,
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    });


    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {
        Route::get('/dashboard', function () { return Inertia::render('Dashboard', ['canView' => Auth::user()->hasRole('superadministrator')]); })->name('dashboard');
        Route::get('/products', function () { return Inertia::render('Product/Products', ['canView' => Auth::user()->hasRole('superadministrator')]); })->name('products');
        Route::get('/imports', function () { return Inertia::render('Imports', ['canView' => Auth::user()->hasRole('superadministrator')]); })->name('imports');
        Route::get('/exports', function () { return Inertia::render('Exports/Exports', ['canView' => Auth::user()->hasRole('superadministrator')]); })->name('exports');
        Route::get('/expences', function () { return Inertia::render('Expences/Expences', ['canView' => Auth::user()->hasRole('superadministrator')]); })->name('expences');
        Route::get('/investors', function () { return Inertia::render('Investors/Investors', ['canView' => Auth::user()->hasRole('superadministrator')]); })->name('investors');
    });
