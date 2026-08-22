<?php

use App\Http\Controllers\ArrivalController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JumantikController;
use App\Http\Controllers\Pengurus\Arrival\ArrivalConfirmController;
use App\Http\Controllers\Pengurus\ArrivalController as PengurusArrivalController;
use App\Http\Controllers\Pengurus\ConfigController;
use App\Http\Controllers\Pengurus\DashboardController;
use App\Http\Controllers\Pengurus\JumantikController as PengurusJumantikController;
use App\Http\Controllers\Pengurus\LogoutWhatsapp;
use App\Http\Controllers\Pengurus\Request\RequestCancelController;
use App\Http\Controllers\Pengurus\Request\RequestConfirmController;
use App\Http\Controllers\Pengurus\Request\RequestNotifyController;
use App\Http\Controllers\Pengurus\RequestController as PengurusRequestController;
use App\Http\Controllers\Pengurus\RtController;
use App\Http\Controllers\Pengurus\SequenceController;
use App\Http\Controllers\Pengurus\WargaController;
use App\Http\Controllers\Posyandu\LaporanController;
use App\Http\Controllers\RequestCheck;
use App\Http\Controllers\RequestController;
use App\Livewire\ArrivalForm;
use App\Livewire\JumantikForm;
use App\Livewire\LoginForm;
use App\Livewire\Posyandu\Dashboard;
use App\Livewire\Posyandu\HealthForm;
use App\Livewire\Posyandu\HealthRecords;
use App\Livewire\Posyandu\Laporan;
use App\Livewire\Posyandu\LoginForm as PosyanduLoginForm;
use App\Livewire\Posyandu\PosyanduPos;
use App\Livewire\Posyandu\Summary;
use App\Livewire\Posyandu\TeenForm;
use App\Livewire\Posyandu\TeenRecords;
use App\Livewire\RequestForm;
use App\Models\Request as ModelsRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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

// Posyandu subdomain routes
Route::domain(config('app.posyandu_domain'))->name('posyandu.')->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');
    Route::middleware(['posyandu.role'])->group(function () {
        Route::get('/teens', TeenRecords::class)->name('teens.index');
        Route::get('/teens/form/{nik?}', TeenForm::class)->name('teens.form');
        Route::get('/teens/records/{nik}', HealthRecords::class)->name('teens.records');
        Route::get('/teens/records/{nik}/form/{id?}', HealthForm::class)->name('teens.records.form');
        Route::get('/teens/records/{nik}/delete/{id}', HealthForm::class)->name('teens.records.delete');
        Route::get('/pos/{type}/{step}', PosyanduPos::class)->name('pos');
        Route::get('/laporan/{type}', Laporan::class)->name('laporan');
        Route::get('/laporan/{type}/download', LaporanController::class)->name('laporan.download');
        Route::get('/summary/{type}', Summary::class)->name('summary');
    });

    Route::get('logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('error', 'Logout berhasil');
    })->name('logout');

    Route::get('login', PosyanduLoginForm::class)->name('login');

    Route::fallback(function () {
        abort(404);
    });
});

Route::get('', HomeController::class)->name('home');
Route::get('login', LoginForm::class)->name('login');
Route::get('form-request', RequestForm::class)->name('request.create');
Route::get('request/{code}', RequestController::class)->name('request.show');
Route::view('jali-jali', 'jali-form')->name('jali.index');

Route::view('check-request', 'request.check')->name('request.check');
Route::post('check-request', RequestCheck::class);

Route::get('form-arrival', ArrivalForm::class)->name('arrival.create');
Route::get('arrival/{nik}', ArrivalController::class)->name('arrival.show');

Route::get('jumantik', JumantikForm::class)->name('jumantik.create');
Route::get('jumantik/{id}', JumantikController::class)->name('jumantik.show');

Route::get('document', function () {
    $data['request'] = ModelsRequest::first();

    return view('document', $data);
});
Route::get('document/pdf', function () {
    $data['request'] = ModelsRequest::first();
    $pdf = Pdf::loadView('document', $data);

    return $pdf->download();
});

Route::middleware('auth')->prefix('pengurus')->name('pengurus.')->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');
    Route::resource('rt', RtController::class);
    Route::resource('sequence', SequenceController::class);
    Route::resource('warga', WargaController::class);
    Route::get('request/{id}/confirm', RequestConfirmController::class)->name('request.confirm');
    Route::get('request/{id}/cancel', RequestCancelController::class)->name('request.cancel');
    Route::resource('request', PengurusRequestController::class);
    Route::get('config', ConfigController::class)->name('config');
    Route::get('request/{id}/notif/{type}', RequestNotifyController::class)->name('request.notif');

    Route::get('arrival/{id}/confirm', ArrivalConfirmController::class)->name('arrival.confirm');
    Route::resource('arrival', PengurusArrivalController::class);
    Route::get('jumantik', [PengurusJumantikController::class, 'index'])->name('jumantik.index');
    Route::delete('jumantik/{id}', [PengurusJumantikController::class, 'destroy'])->name('jumantik.destroy');
    Route::get('logout-whatsapp', LogoutWhatsapp::class)->name('whatsapp.logout');
    Route::get('logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    })->name('logout');
});

Route::post('callback', function (Request $request) {
    Log::channel('whatsapp')->info('Whatsapp Callback - All Request Data:', [
        'method' => $request->method(),
        'url' => $request->fullUrl(),
        'body' => $request->all(),
        'ip' => $request->ip(),
        'user_agent' => $request->userAgent(),
    ]);

    return response()->json([
        'message' => 'Callback received',
    ]);
});

Route::get('lara-logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
