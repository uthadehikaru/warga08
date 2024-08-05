<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Pengurus\DashboardController;
use App\Http\Controllers\Pengurus\RequestController as PengurusRequestController;
use App\Http\Controllers\Pengurus\RtController;
use App\Http\Controllers\RequestCheck;
use App\Http\Controllers\RequestController;
use App\Livewire\LoginForm;
use App\Livewire\RequestForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('', HomeController::class)->name('home');
Route::get('login', LoginForm::class)->name('login');
Route::get('form-request', RequestForm::class)->name('request.create');
Route::get('request/{code}', RequestController::class)->name('request.show');
Route::view('check-request', 'request.check')->name('request.check');
Route::post('check-request', RequestCheck::class);

Route::middleware('auth')->prefix('pengurus')->name('pengurus.')->group(function(){
    Route::get('dashboard', DashboardController::class)->name('dashboard');  
    Route::resource('rt', RtController::class);
    Route::resource('request', PengurusRequestController::class);
    Route::get('logout', function(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    })->name('logout');
});


Route::get('lara-logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
