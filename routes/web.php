<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\PengajuanCutiController;
use App\Http\Controllers\LaporanCutiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

// ROUTE UNTUK STAFF YANG MELAKUKAN PENGAJUAN CUTI
Route::get('/staff/pengajuancuti', function () {
    return view('home.staff.pengajuancuti'); 
});

// ROUTE UNTUK MENGIRIM PENGAJUAN CUTI
Route::post('/submit-pengajuancuti', [PengajuanCutiController::class, 'kirimPengajuanCuti'])->middleware('auth');

// ROUTE UNTUK AUTOCOMPLETE NAMA STAFF
Route::get('/staff/search', [StaffController::class, 'search'])->name('staff.search');


// MENAMPILKAN PENGAJUAN CUTI DI APLIKASI ADMIN (USER)
// Route::get('/user/pengajuancuti', [PengajuanCutiController::class, 'index'])->name('home.user.pengajuancuti');

// ROUTE AKSI APPROVE DAN REJECTED
Route::get('/user/pengajuancuti', [PengajuanCutiController::class, 'index'])->name('user.pengajuancuti');
Route::post('/user/pengajuancuti/approve/{id}', [PengajuanCutiController::class, 'approve'])->name('user.approve-pengajuan');
Route::post('/user/pengajuancuti/reject/{id}', [PengajuanCutiController::class, 'reject'])->name('user.reject-pengajuan');

// ROUTE UNTUK DETAIL PENGAJUAN CUTI (DI DASHBOARD) DAN UPDATE STATUS
Route::get('/user/pengajuan/{id}', [PengajuanCutiController::class, 'detail'])->name('user.detail-pengajuan');
Route::post('/user/pengajuan/{id}/update', [PengajuanCutiController::class, 'updateStatus'])->name('user.pengajuan.update');


// ROUTE UNTUK MENAMPILKAN/MENDAPATKAN SISA CUTI BERDASARKAN ID STAFF
Route::get('/staff/sisa-cuti/{id}', [StaffController::class, 'getSisaCuti'])->name('staff.sisaCuti');

// ROUTE UNTUK MENAMPILKAN DATA PENGAJUAN CUTI (BENTUK LIST INFORMASI PENGAJUAN DI DASHBOARD)
Route::get('/user/dashboard', [PengajuanCutiController::class, 'dashboard'])->name('user.dashboard');

// ROUTE MENGARAH KE FUNGSI DASHBOARD
Route::get('/dashboard', [PengajuanCutiController::class, 'dashboard'])->name('dashboard');

// Route Login
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/actionlogin', [LoginController::class, 'actionLogin'])->name('actionLogin');
Route::get('/logout', [LoginController::class, 'actionLogout'])->name('actionLogout');

Route::middleware('auth')->group(function () {

    // Halaman Dashbboard
    Route::get('/', [DashboardController::class, 'index']);

    // CRUD USER
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/tambah', [UserController::class, 'create']);
    Route::post('/user/simpan', [UserController::class, 'store']);
    Route::get('/user/{id}/show', [UserController::class, 'show']);
    Route::post('/user/{id}/update', [UserController::class, 'update']);
    Route::delete('/user/{id}/delete', [UserController::class, 'destroy']);
    Route::post('/users/reset-password', [UserController::class, 'resetPassword'])->name('users.resetPassword');

    // CRUD Staff
    Route::get('/staff', [StaffController::class, 'index']);
    Route::get('/staff/tambah', [StaffController::class, 'create']);
    Route::post('/staff/simpan', [StaffController::class, 'store']);
    Route::get('/staff/{id}/show', [StaffController::class, 'show']);
    Route::post('/staff/{id}/update', [StaffController::class, 'update']);
    Route::delete('/staff/{id}/delete', [StaffController::class, 'destroy']);

    // CRUD Cuti
    Route::get('/cuti', [CutiController::class, 'index'])->name('cuti.index');
    Route::get('/cuti/tambah', [CutiController::class, 'create'])->name('cuti.create');
    Route::post('/cuti/simpan', [CutiController::class, 'store'])->name('cuti.store');
    Route::get('/cuti/{id}/delete', [CutiController::class, 'destroy']);

    // BULK
    Route::delete('/cuti/bulk-delete', [CutiController::class, 'bulkDelete'])->name('cuti.bulkDelete');

    // Detail Cuti ('Lihat')
    Route::get('/cuti/{id}/detail', [CutiController::class, 'show'])->name('cuti.detail');

    // Laporan Cuti
    Route::get('/laporancuti', [LaporanCutiController::class, 'index'])->name('laporancuti.index');

});
