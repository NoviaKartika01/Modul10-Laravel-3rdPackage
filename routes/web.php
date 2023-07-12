<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// gruping route untuk proteksi dengan midleware, agar tiap halaman tidak bisa langsung diakses, harus lewat login
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('profile', ProfileController::class)->name('profile');
    Route::resource('employees', EmployeeController::class);

    // untuk download file, di lindungi auth agar hanya bisa download setelah berhasil login sistem
    Route::get('download-file/{employeeId}', [EmployeeController::class, 'downloadFile'])->name('employees.downloadFile');
});

// proteksi agar halaman login, memastikan user tidak bisa mengakses rute-rute dibawah jika sudah melakukan otentikasi(guest)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login')
    ->middleware('guest');

// Meletakkan File pada Local Disk
Route::get('/local-disk', function() {
    Storage::disk('local')->put('local-example.txt', 'This is local example content');
    return asset('storage/local-example.txt');
});

// Meletakkan File pada Public Disk
Route::get('/public-disk', function() {
    Storage::disk('public')->put('public-example.txt', 'This is public example content');
    return asset('storage/public-example.txt');
});

// Menampilkan Isi File Local
Route::get('/retrieve-local-file', function() {
    if (Storage::disk('local')->exists('local-example.txt')) {
        $contents = Storage::disk('local')->get('local-example.txt');
    } else {
        $contents = 'File does not exist';
    }

    return $contents;
});

// Menampilkan Isi File Public
Route::get('/retrieve-public-file', function() {
    if (Storage::disk('public')->exists('public-example.txt')) {
        $contents = Storage::disk('public')->get('public-example.txt');
    } else {
        $contents = 'File does not exist';
    }

    return $contents;
});

// Mendownload File Local
Route::get('/download-local-file', function() {
    return Storage::download('local-example.txt', 'local file');
});

// Mendownload File Public
Route::get('/download-public-file', function() {
    return Storage::download('public/public-example.txt', 'public file');
});

// Menampilkan URL dari File
Route::get('/file-url', function() {
    // Just prepend "/storage" to the given path and return a relative URL
    $url = Storage::url('local-example.txt');
    return $url;
});

// Menampilkan Size dari File
Route::get('/file-size', function() {
    $size = Storage::size('local-example.txt');
    return $size;
});
// Menampilkan Path dari File
Route::get('/file-path', function() {
    $path = Storage::path('local-example.txt');
    return $path;
});

// Buat Route baru Untuk Menyimpan File via Form
Route::get('/upload-example', function() {
    return view('upload_example');
});

Route::post('/upload-example', function(Request $request) {
    $path = $request->file('avatar')->store('public');
    return $path;
})->name('upload-example');

// Menghapus File pada Storage
Route::get('/delete-local-file', function(Request $request) {
    Storage::disk('local')->delete('local-example.txt');
    return 'Deleted';
});

Route::get('/delete-public-file', function(Request $request) {
    Storage::disk('public')->delete('jdLqECPGV7vmFfVFiPIx7lNl5LJu9HGIra3FxdlV.pdf');
    return 'Deleted';
});

// server-side processing Data Tables
Route::get('getEmployees', [EmployeeController::class, 'getData'])->name('employees.getData');

// Untuk ke rute export file excel
Route::get('exportExcel', [EmployeeController::class, 'exportExcel'])->name('employees.exportExcel');

// untuk ke rute export file pdf
Route::get('exportPdf', [EmployeeController::class, 'exportPdf'])->name('employees.exportPdf');

// // Route HomeController untuk halaman Home
// Route::get('home', [HomeController::class, 'index'])->name('home');

// // Route ProfileController untuk halaman My Profile
// Route::get('profile', ProfileController::class)->name('profile');

// // Route EmployeeController untuk halaman Employee
// Route::resource('employees', EmployeeController::class);

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
