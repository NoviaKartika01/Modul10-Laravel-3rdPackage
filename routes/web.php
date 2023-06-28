<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\Auth\LoginController;

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

// route awal
Route::get('/', function () {
    return view('welcome');
});
// redirect route awal (/) ke route halaman login
Route::redirect('/', '/login');

// route auth
Auth::routes();

// gruping route untuk proteksi dengan midleware, agar tiap halaman tidak bisa langsung diakses, harus lewat login
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('profile', ProfileController::class)->name('profile');
    Route::resource('employees', EmployeeController::class);
});

// proteksi agar halaman login, memastikan user tidak bisa mengakses rute-rute dibawah jika sudah melakukan otentikasi(guest)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login')
    ->middleware('guest');



// // Route HomeController untuk halaman Home
// Route::get('home', [HomeController::class, 'index'])->name('home');

// // Route ProfileController untuk halaman My Profile
// Route::get('profile', ProfileController::class)->name('profile');

// // Route EmployeeController untuk halaman Employee
// Route::resource('employees', EmployeeController::class);

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
