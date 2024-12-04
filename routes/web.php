<?php

use App\Http\Controllers\AdminFacilityController;
use App\Http\Controllers\adminPageController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\approvedController;
use App\Http\Controllers\cancellationController;
use App\Http\Controllers\declinedController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\historyController;
use App\Http\Controllers\HomepageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingpageController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PembatalanController;
use App\Http\Controllers\LaporankerusakanpageController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\RentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\SubmissionController;
use App\Models\Pemesanan;
use App\Http\Controllers\AdminScheduleController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\AdminUserController;

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

// Landing Page
Route::get('/', [LandingpageController::class, 'index'])->middleware('guest');

// Facility Page
Route::get('/facility', [FacilityController::class, 'index']);

// Homepage
Route::get('/homepage', [HomepageController::class, 'index'])->middleware('auth');
Route::post('/updateKelas', [HomepageController::class, 'fetchKelasbyFacilityId']);
Route::post('/checkAvailability', [HomepageController::class, 'checkAvailability']);

//Pembatalanpage
Route::get('/pembatalanpage', [PembatalanController::class, 'index'])->middleware('auth');
Route::get('/pembatalanpage2', [PembatalanController::class, 'index2'])->middleware('auth');
Route::post('/cancelpesanan', [PembatalanController::class, 'batalPesanan'])->middleware('auth');

//Laporankerusakanpage
Route::get('/laporankerusakanpage', [LaporankerusakanpageController::class, 'index'])->middleware('auth');
Route::get('/laporankerusakanpage2', [LaporankerusakanpageController::class, 'index2'])->middleware('auth');
Route::post('/getfacilityinfo', [LaporankerusakanpageController::class, 'getFacilityInfo'])->middleware('auth');
Route::post('/getpemesananinfo', [LaporankerusakanpageController::class, 'getPemesananInfo'])->middleware('auth');
Route::post('/postlaporan', [LaporankerusakanpageController::class, 'postLaporanKerusakan'])->middleware('auth');

// Login
Route::get('/login', [LoginController::class, 'index'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);

// Register
Route::get('/register', [RegisterController::class, 'create'])->middleware('guest');
Route::post('/register', [RegisterController::class, 'store']);

// Logout
Route::post('/logout', [LoginController::class, 'logout']);

//Status Pemesanan
Route::get('/status_pemesanan', [StatusController::class, 'index'])->middleware('auth');
Route::post('/getpemesanandetail', [StatusController::class, 'getPemesananDetail'])->middleware('auth');

// Rent Page
Route::get('/rentpage', [RentController::class, 'index'])->middleware('auth');
Route::post('/rent', [RentController::class, 'store'])->middleware('auth');

// ROUTES UNTUK ADMIN

// // Dashboard - Admin
Route::get('/admin/dashboard', [adminPageController::class, 'index'])->middleware(['auth', 'admin']);

// // History - Admin
Route::get('/admin/history', [historyController::class, 'index'])->middleware(['auth', 'admin']);

// // Cancellation - Admin
Route::get('/admin/cancellation', [cancellationController::class, 'index'])->middleware(['auth', 'admin']);

//Admin Permintaan Reservasi
Route::get('/admin/reservasi', [SubmissionController::class, 'index']);
Route::post('/admin/submission/{id}/deny', [SubmissionController::class, 'deny'])->name('submission.deny');
Route::post('/admin/submission/{id}/approve', [SubmissionController::class, 'approve'])->name('submission.approve');


// // Lapor Kerusakan - Admin
// Route::get('/admin/kerusakan', [ReportController::class, 'index'])->middleware('auth');
Route::get('/admin/kerusakan', [ReportController::class, 'index'])->middleware(['auth', 'admin']);
Route::post('/donereviewkerusakan', [ReportController::class, 'doneReview'])->middleware(['auth', 'admin']);

// Add Fasilitas - Admin
// Route::get('/admin/addfacility', [FacilityController::class, 'addFacility'])->middleware(['auth', 'admin']);
Route::resource('/admin/facilities', AdminFacilityController::class)->middleware(['auth', 'admin']);
Route::resource('kelas', KelasController::class)->parameters([
    'kelas' => 'kelas',
]);

// Jadwal - Admin
Route::prefix('admin/schedules')->group(function () {
    Route::get('/', [AdminScheduleController::class, 'index'])->name('schedules.index');
    Route::get('/list', [AdminScheduleController::class, 'listSchedule'])->name('schedules.list');
    Route::get('/{schedule}/edit', [AdminScheduleController::class, 'edit'])->name('schedules.edit');
    Route::post('/', [AdminScheduleController::class, 'store'])->name('schedules.store');
    Route::put('/{schedule}', [AdminScheduleController::class, 'update'])->name('schedules.update');
    Route::delete('/{schedule}', [AdminScheduleController::class, 'destroy'])->name('schedules.destroy');
});

// Jadwal - Peminjam
Route::middleware('auth')->group(function () {
    Route::get('/schedule', [ScheduleController::class, 'index'])->name('modules.schedule.index');
    Route::get('/schedule/list', [ScheduleController::class, 'listSchedule'])->name('modules.schedule.list');

// M akun
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('admin/users/{id}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
    Route::put('admin/users/{id}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('admin/users/{id}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
});

});