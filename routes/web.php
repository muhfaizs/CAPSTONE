<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CertificateController; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Storage;
use App\Models\Certificate;

// Route to serve certificate files from database (for Vercel compatibility)
Route::get('/certificate-file/{id}', function ($id) {
    $certificate = Certificate::findOrFail($id);
    
    // Check if file content exists in database
    if ($certificate->file_content) {
        $content = base64_decode($certificate->file_content);
        $mimeType = $certificate->file_mime_type ?? 'application/pdf';
        $fileName = $certificate->file_name ?? 'certificate.pdf';
        
        return response($content, 200)
            ->header('Content-Type', $mimeType)
            ->header('Content-Disposition', 'inline; filename="' . $fileName . '"');
    }
    
    // Fallback to file path if exists
    if ($certificate->file_path && Storage::disk('public')->exists($certificate->file_path)) {
        $file = Storage::disk('public')->get($certificate->file_path);
        $mimeType = Storage::disk('public')->mimeType($certificate->file_path);
        
        return response($file, 200)->header('Content-Type', $mimeType);
    }
    
    abort(404, 'File not found');
})->name('certificate.file')->middleware('auth');

// Route to serve storage files (for Vercel compatibility)
Route::get('/storage/{path}', function ($path) {
    if (!Storage::disk('public')->exists($path)) {
        abort(404);
    }
    
    $file = Storage::disk('public')->get($path);
    $mimeType = Storage::disk('public')->mimeType($path);
    
    return response($file, 200)->header('Content-Type', $mimeType);
})->where('path', '.*');

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('welcome');
    }
    return redirect()->route('login');
})->middleware('setlocale');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('setlocale');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register')->middleware('setlocale');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/forgot-password', function() { return view('forgot-password'); })->name('password.request')->middleware('setlocale');
Route::post('/forgot-password', [AuthController::class, 'updatePassword'])->name('password.update');

Route::get('/edit-password', [\App\Http\Controllers\EditPasswordController::class, 'show'])->name('password.edit')->middleware('setlocale');
Route::post('/edit-password', [\App\Http\Controllers\EditPasswordController::class, 'update'])->name('password.edit.update');

Route::post('/switch-language-ajax', [App\Http\Controllers\LanguageController::class, 'switchLanguageAjax'])->name('lang.switch.ajax');
Route::get('/switch-language/{language}', [App\Http\Controllers\LanguageController::class, 'switchLanguage'])->name('lang.switch');
Route::get('/current-language', [App\Http\Controllers\LanguageController::class, 'getCurrentLanguage'])->name('lang.current');

Route::middleware(['auth', 'setlocale'])->group(function () {
    // Welcome route - dinamis berdasarkan role
    Route::get('/welcome', function() {
        $user = Auth::user();
        if ($user->role === 'Employee') {
            return view('employee.welcome');
        }
        return view('welcome');
    })->name('welcome');
    
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    
    // Dashboard routes - hanya untuk HRD
    Route::middleware(['role:HRD'])->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/stats', [\App\Http\Controllers\DashboardController::class, 'getStats'])->name('dashboard.stats');
    });
    
    // Certificate routes untuk HRD - specific routes first
    Route::middleware(['role:HRD'])->group(function () {
        Route::get('/certificate/search', [CertificateController::class, 'search'])->name('certificate.search');
        Route::get('/certificate/ajax-search', [CertificateController::class, 'ajaxSearch'])->name('certificate.ajaxSearch');
        Route::get('/certificate/create', [CertificateController::class, 'create'])->name('certificate.create');
        Route::post('/certificate', [CertificateController::class, 'store'])->name('certificate.store');
        Route::post('certificate/preview-excel', [CertificateController::class, 'previewExcel'])->name('certificate.previewExcel');
        Route::post('certificate/preview-pdf', [CertificateController::class, 'previewPdf'])->name('certificate.previewPdf');
        Route::post('certificate/import-excel', [CertificateController::class, 'importExcel'])->name('certificate.importExcel');
        Route::post('certificate/import-pdf', [CertificateController::class, 'importPdf'])->name('certificate.importPdf');
        Route::post('certificate/import', [CertificateController::class, 'import'])->name('certificate.import');
        Route::get('/certificate/{certificate}/edit', [CertificateController::class, 'edit'])->name('certificate.edit');
        Route::put('/certificate/{certificate}', [CertificateController::class, 'update'])->name('certificate.update');
        Route::post('/certificate/update', [CertificateController::class, 'update'])->name('certificate.update.post');
        Route::delete('/certificate/{certificate}', [CertificateController::class, 'destroy'])->name('certificate.destroy');
        Route::post('/certificate/bulk-delete', [CertificateController::class, 'bulkDelete'])->name('certificate.bulkDelete');

        // Routes for adding new dropdown options
        Route::post('/business-units', [CertificateController::class, 'storeBusinessUnit'])->name('business-units.store');
        Route::post('/qualifications', [CertificateController::class, 'storeQualification'])->name('qualifications.store');
        Route::post('/lsps', [CertificateController::class, 'storeLsp'])->name('lsps.store');

        // Route for getting qualifications by LSP
        Route::get('/qualifications-by-lsp/{lspId}', [CertificateController::class, 'getQualificationsByLsp'])->name('qualifications.by.lsp');
    });

    // Certificate routes untuk Employee
    Route::middleware(['role:Employee'])->group(function () {
        Route::get('/employee/certificate/search', [\App\Http\Controllers\EmployeeCertificateController::class, 'search'])->name('employee.certificate.search');
        Route::get('/employee/certificate/ajax-search', [\App\Http\Controllers\EmployeeCertificateController::class, 'ajaxSearch'])->name('employee.certificate.ajaxSearch');
        Route::get('/employee/certificate/create', [\App\Http\Controllers\EmployeeCertificateController::class, 'create'])->name('employee.certificate.create');
        Route::post('/employee/certificate', [\App\Http\Controllers\EmployeeCertificateController::class, 'store'])->name('employee.certificate.store');
        Route::get('/employee/certificate/{certificate}/edit', [\App\Http\Controllers\EmployeeCertificateController::class, 'edit'])->name('employee.certificate.edit');
        Route::put('/employee/certificate/{certificate}', [\App\Http\Controllers\EmployeeCertificateController::class, 'update'])->name('employee.certificate.update');
        Route::delete('/employee/certificate/{certificate}', [\App\Http\Controllers\EmployeeCertificateController::class, 'destroy'])->name('employee.certificate.destroy');
    });

    // Route for testing email
    Route::get('/test-mail', [App\Http\Controllers\MailController::class, 'testMail']);

});
