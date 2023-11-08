<?php

use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LoginRegisterController;

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
    return view('home');
});
Route::get('/user/home', [LoginRegisterController::class, 'userhome'])->name('user.home');

Route::get('/admin/home', [LoginRegisterController::class, 'adminhome'])->name('admin.home');

Route::post('/postRegister', [LoginRegisterController::class, 'postRegister'])->name('postRegister');

Route::post('/postLogin', [LoginRegisterController::class, 'postLogin'])->name('postLogin');

Route::post('/logout', [LoginRegisterController::class, 'logout'])->name('logout'); 

Route::middleware(['guest'])->group(function () {
    Route::get('/', function (){
        return view('home');
    });
    Route::get('/auth/login', [LoginRegisterController::class, 'login'])->name('auth.login');
    Route::get('/auth/register', [LoginRegisterController::class, 'register'])->name('auth.register');
});

Route::group(['middleware' => ['auth', 'checklevel:admin']], function () {
    Route::get('/admin/home', [LoginRegisterController::class, 'adminhome'])->name('admin.home');
});

#baru di tambah
Route::get('/admin/tambah', [AdminController::class, 'tambah'])->name('admin.tambah');
Route::get('/editAdmin/{id}', [AdminController::class, 'editAdmin'])->name('editAdmin');
Route::get('/deleteAdmin/{id}', [AdminController::class,'deleteAdmin'])->name('deleteAdmin');
Route::post('/tambahAdmin', [AdminController::class, 'postTambahAdmin'])->name('postTambahAdmin');
Route::post('/postEditAdmin/{id}', [AdminController::class,'postEditAdmin'])->name('postEditAdmin');

Route::get('/admin/buku', [AdminController::class, 'adminBuku'])->name('admin.buku');
Route::get('/admin/tambahBuku', [AdminController::class,'tambahBuku'])->name('admin.tambahBuku');
Route::get('/admin/editBuku/{id}', [AdminController::class,'editBuku'])->name('admin.editBuku');
Route::get('/admin/deleteBuku/{id}', [AdminController::class,'deleteBuku'])->name('admin.deleteBuku');

Route::get('/admin/peminjaman', [AdminController::class,'adminPeminjaman'])->name('admin.peminjaman');
Route::get('/admin/tambahPeminjaman', [AdminController::class,'tambahPeminjaman'])->name('admin.tambahPeminjaman');
Route::get('/admin/editPeminjaman/{id}', [AdminController::class,'editPeminjaman'])->name('admin.editPeminjaman');
Route::get('/admin/deletePeminjaman/{id}', [AdminController::class,'deletePeminjaman'])->name('admin.deletePeminjaman');
Route::get('/admin/detailPeminjaman/{id_peminjaman}/{id_user}/{id_buku}', [AdminController::class, 'detailPeminjaman'])->name('admin.detailPeminjaman');

Route::get('/admin/cetakPeminjaman', [AdminController::class,'cetakDataPeminjaman'])->name('admin.cetakDataPeminjaman');

Route::post('/postTambahBuku', [AdminController::class,'postTambahBuku'])->name('postTambahBuku');
Route::post('/postEditBuku/{id}', [AdminController::class,'postEditBuku'])->name('postEditBuku');

Route::post('/postTambahPeminjaman', [AdminController::class,'postTambahPeminjaman'])->name('postTambahPeminjaman');
Route::post('/postEditPeminjaman/{id}', [AdminController::class,'postEditPeminjaman'])->name('postEditPeminjaman');

Route::group(['middleware' => ['auth', 'checklevel:user']], function () {
    Route::get('/user/home', [LoginRegisterController::class, 'userhome'])->name('user.home');
    
});

Route::get('/logout', [LoginRegisterController::class, 'logout'])->name('logout'); 
Route::post('/postlogin', [LoginRegisterController::class, 'login'])->name('postlogin'); 
Route::post('/postregister', [LoginRegisterController::class, 'register'])->name('postregister'); 

