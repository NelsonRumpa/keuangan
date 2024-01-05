<?php

use App\Models\kategori;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\kategoriController;
use App\Http\Controllers\transaksiController;
use App\Http\Controllers\approvedController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\registerController;
use Illuminate\Support\Facades\Auth;
use App\Models\transaksi;

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

Route::get('/kategori', function () {
    return view('pegawai.kategori');
})->middleware(['auth', 'pegawai']);

Route::get('/transaksi', function () {
    return view('pegawai.transaksi');
})->middleware(['auth', 'pegawai']);

Route::get('/bendahara', function () {
    return view('bendahara.approved');
})->middleware(['auth', 'bendahara']);

Route::get('/', [loginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/', [loginController::class, 'authenticate']);
Route::post('/logout', [loginController::class, 'logout']);


Route::get('/register', [registerController::class, 'indexx']);
Route::post('/register', [registerController::class, 'storee']);

Route::get('/transadmin', function () {
    return view('admin.transaksi');
})->middleware(['auth', 'admin']);

Route::get('/katadmin', function () {
    return view('admin.kategori');
})->middleware(['auth', 'admin']);

Route::get('/appadmin', function () {
    return view('admin.approved');
})->middleware(['auth', 'admin']);

Route::get('/admin', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'admin']);

Route::get('/rejectmin', function () {
    return view('admin.rejected');
})->middleware(['auth', 'admin']);




// kategori 

Route::post('/kategori', [kategoriController::class, 'kate'])->name('peka')->middleware(['auth', 'pegawai']);

Route::get('/kategori', [kategoriController::class, 'getKat'])->name('getkate')->middleware(['auth', 'pegawai']);

Route::post('/katadmin', [kategoriController::class, 'kat3'])->name('p3ka')->middleware(['auth', 'admin']);

Route::get('/katadmin', [kategoriController::class, 'getKat2'])->name('getkat3')->middleware(['auth', 'admin']);

Route::get('/delet/{id}', [kategoriController::class, 'delKategori'])->name('delete');

Route::get('/kategori/{id}', [kategoriController::class, 'edit'])->name('data.editt');

Route::put('/update/{id}', [kategoriController::class, 'update'])->name('data.updatee');


// transaksi

Route::post('/transaksi', [transaksiController::class, 'store'])->name('postra')->middleware(['auth', 'pegawai']);

Route::get('/transaksi', [transaksiController::class, 'getTra'])->name('gettran')->middleware(['auth', 'pegawai']);

Route::get('/delete/{id}', [transaksiController::class, 'delTransaksi'])->name('deletee');

Route::post('/transadmin', [transaksiController::class, 'stor3'])->name('postra2')->middleware(['auth', 'admin']);

Route::get('/transadmin', [transaksiController::class, 'getTra2'])->name('gettran2')->middleware(['auth', 'admin']);

Route::get('/rejectmin', [transaksiController::class, 'getRejected'])->name('rejected')->middleware(['auth', 'admin']);

Route::get('/admin', [transaksiController::class, 'getTra3'])->middleware(['auth', 'admin']);

Route::get('/edit/{id}', [transaksiController::class, 'edit'])->name('data.edit');

Route::put('/transaksi/{id}', [transaksiController::class, 'update'])->name('data.update');

Route::get('/trans', [transaksiController::class, 'filter'])->name('filter')->middleware(['auth', 'admin']);

Route::get('/pegtrans', [transaksiController::class, 'filter2'])->name('filter2')->middleware(['auth', 'pegawai']);

Route::get('/cetak-pdf', [transaksiController::class, 'generatePDF'])->name('cetakpdf');

Route::get('/generateExcel', [transaksiController::class, 'export_excel'])->name('excel');





// approved dan rejected

Route::get('/bendahara', [approvedController::class, 'getApp'])->name('getapp')->middleware(['auth', 'bendahara']);

Route::get('/save/{id}', [approvedController::class, 'approve'])->name('appro');

Route::get('/appadmin', [approvedController::class, 'g3tApp'])->name('g3tapp')->middleware(['auth', 'admin']);

Route::post('/reject/{id}', [approvedController::class, 'reject'])->name('reject');
