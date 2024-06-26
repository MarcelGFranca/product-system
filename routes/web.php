<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RegisteredUserController;

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

Route::get('/', function () {
	return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
	Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
	Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
	Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

	Route::get('/dashboard', function () {
		return view('dashboard');
	})->name('dashboard');
});


Route::group(['middleware' => ['role:common']], function () {
	Route::get('/products', function () {
		return view('products');
	})->name('products');
	Route::get('/categories', function () {
		return view('categories');
	})->name('categories');
	Route::get('/brands', function () {
		return view('brands');
	})->name('brands');
});

Route::group(['middleware' => ['role:admin']], function () {
	Route::get('index-profiles', [ProfileController::class, 'index'])->name('profile.index');
	Route::get('show/{id}', [ProfileController::class, 'show'])->name('profile.show');
	Route::resource('permissions', App\Http\Controllers\PermissionController::class);
	Route::get('permissions/{permissionId}/delete', [App\Http\Controllers\PermissionController::class, 'destroy']);
	Route::resource('roles', App\Http\Controllers\RoleController::class);
	Route::get('roles/{roleId}/delete', [App\Http\Controllers\RoleController::class, 'destroy']);
	Route::get('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'addPermissionToRole']);
	Route::put('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'givePermissionToRole']);
	Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
});

require __DIR__ . '/auth.php';
