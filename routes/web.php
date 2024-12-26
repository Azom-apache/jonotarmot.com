<?php

use App\Http\Middleware\AttachUser;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\PollController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Session; 
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\TranslationController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\AdminDashboardController;
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

Route::post('set-locale', function (Illuminate\Http\Request $request) {
    $locale = $request->input('locale');
    Session::put('locale', $locale);
    return redirect()->back();
})->name('setLocale');
// Route::get('/', [PollController::class, 'homePage'])->name('home');
Route::get('/poll/{id}', [PollController::class, 'showPollDetails'])->name('showPollDetails');
Route::post('/poll/{id}/vote', [PollController::class, 'submitVote'])->name('poll.vote');
Route::resource('/register', UserController::class);
Route::post('/userRegister', [AdminAuthController::class, 'userRegister'])->name('userRegister');
Route::post('/otpverification', [AdminAuthController::class, 'otpVerification'])->name('otpVerification');
Route::get('/', [AdminAuthController::class, 'showLoginForm'])->name('login');
Route::post('/logincheck', [AdminAuthController::class, 'login'])->name('logincheck');
Route::get('/logout', [AdminAuthController::class, 'logout'])->name('logout');

Route::middleware([ 'auth','role:user'])->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

});

// Routes for admin 
Route::middleware([ 'auth','role:user'])->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [UserDashboardController::class, 'userProfile'])->name('user.profile');
    Route::post('/updateProfile', [UserDashboardController::class, 'updateProfile'])->name('user.update'); 
    Route::post('/upload-profile-pic',[UserDashboardController::class,'uploadProfilePic'])->name('upload.profile.pic'); 
    Route::get('/translations', [AdminDashboardController::class, 'trnaslationView'])->name('trnaslationView'); 
    Route::get('/translate', [AdminDashboardController::class, 'addTranslation'])->name('addTranslation'); 
    Route::post('save-translations', [AdminDashboardController::class, 'saveTranslations'])->name('saveTranslations');
    Route::get('trans-language-list', [TranslationController::class, 'transLanguageList'])->name('transLanguageList');
    Route::patch('/updateTranslationStatus/{id}', [TranslationController::class, 'updateTranslationStatus'])->name('updateTranslationStatus');
    Route::post('update-translation', [TranslationController::class, 'updateTranslation'])->name('update.translation');
    Route::delete('remove-translation', [TranslationController::class, 'removeTranslation'])->name('remove.translation');

    Route::get('polls', [PollController::class, 'index'])->name('polls.index');
    Route::get('polls/create', [PollController::class, 'create'])->name('polls.create');
    Route::post('polls', [PollController::class, 'store'])->name('polls.store');
    Route::get('polls/{id}/edit', [PollController::class, 'edit'])->name('polls.edit');
    Route::put('polls/{id}', [PollController::class, 'update'])->name('polls.update');
    Route::delete('polls/{id}', [PollController::class, 'destroy'])->name('polls.destroy');
});


