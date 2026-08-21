<?php

use App\Http\Controllers\CyberExpertiseController;
use App\Http\Controllers\ExpertiseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PcePointController;
use App\Http\Controllers\TwoFAController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get(
    '/',
    function () {
        return view('welcome');
    }
);
Route::get(
    '/over',
    function () {
        return view('about');
    }
);

Auth::routes();

Route::post('search', [UserController::class, 'search'])->name('expert.search');
Route::get('expert/{user}', [UserController::class, 'show'])->name('expert.show');

Route::group(
    ['middleware' => ['auth', '2fa', 'webauthn']],
    function () {
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::get('/logout', [HomeController::class, 'logout'])->name('logout');
        Route::resource('users', UserController::class);
        Route::post('users/search', [UserController::class, 'search'])->name('users.search');
        Route::resource('pcePoint', PcePointController::class);
        Route::resource('expertise', ExpertiseController::class);
        Route::resource('cyberExpertise', CyberExpertiseController::class);
    }
);

Route::group(
    ['middleware' => 'auth'],
    function () {
        Route::get('/2fa', [TwoFAController::class, 'show2faForm'])->name('2fa');
        Route::post('/generate2faSecret', [TwoFAController::class, 'generate2faSecret'])->name('generate2faSecret');
        Route::post('/2fa', [TwoFAController::class, 'enable2fa'])->name('enable2fa');
        Route::post('/disable2fa', [TwoFAController::class, 'disable2fa'])->name('disable2fa');
        Route::post('/2fa/herstelcodes', [TwoFAController::class, 'regenerateRecoveryCodes'])
            ->name('regenerateRecoveryCodes');
        Route::post(
            '/2faVerify',
            function () {
                return redirect(URL()->previous());
            }
        )->name('2faVerify')->middleware('2fa');
    }
);
