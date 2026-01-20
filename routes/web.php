
<?php

use App\Enums\UserRole;
use App\Http\Controllers\Admin\ManagedUserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function (Request $request) {
        return redirect()->route($request->user()->role->dashboardRouteName());
    })->name('dashboard');

    Route::get('/admin/dashboard', function () {
        return view('dashboard', [
            'title' => 'Dashboard Admin',
            'message' => 'Kelola data master alat, akun petugas, dan peminjam.',
            'roleLabel' => UserRole::Admin->label(),
            'tips' => [
                'Gunakan menu Pengguna untuk membuat akun Petugas baru.',
                'Perbarui stok alat dan kategori sebelum membuka periode peminjaman.',
            ],
        ]);
    })->middleware('role:admin')->name('admin.dashboard');

    Route::get('/petugas/dashboard', function () {
        return view('dashboard', [
            'title' => 'Dashboard Petugas',
            'message' => 'Monitor permintaan peminjaman, proses persetujuan, dan pengembalian alat.',
            'roleLabel' => UserRole::Petugas->label(),
            'tips' => [
                'Cek tab Permintaan Masuk secara berkala untuk mencegah antrean menumpuk.',
                'Catat kondisi alat sebelum diserahkan dan setelah dikembalikan.',
            ],
        ]);
    })->middleware('role:petugas')->name('petugas.dashboard');

    Route::get('/peminjam/dashboard', function () {
        return view('dashboard', [
            'title' => 'Dashboard Peminjam',
            'message' => 'Ajukan peminjaman baru dan lacak status pengajuan yang sedang berjalan.',
            'roleLabel' => UserRole::Peminjam->label(),
            'tips' => [
                'Klik tombol Ajukan Peminjaman untuk memulai permohonan baru.',
                'Pastikan tanggal pengembalian yang diajukan sesuai dengan kebutuhan kegiatan.',
            ],
        ]);
    })->middleware('role:peminjam')->name('peminjam.dashboard');

    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::resource('users', ManagedUserController::class)->except(['show']);
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
