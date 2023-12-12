<?php

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

use App\Http\Controllers\ListingController;
use App\Http\Controllers\ProfileController;
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

// all listings
Route::get('/',[ListingController::class, 'index']);


// create form
Route::get('/listings/create', [ListingController::class, 'create']);

// create job
Route::post('/listings', [ListingController::class, 'store']);


// single listing
Route::get('/listings/{listing}', [ListingController::class, 'show']);

// show edit form
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit']);

// delete listing
Route::delete('/listings/{listing}', [ListingController::class, 'delete']);

// update listing
Route::put('/listings/{listing}', [ListingController::class, 'update']);

// show register form
Route::get('/register', [UserController::class, 'register']);

// new users
Route::post('/users', [UserController::class, 'store']);




// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// require __DIR__.'/auth.php';
