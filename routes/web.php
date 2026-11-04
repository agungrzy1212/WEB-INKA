<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AdminController;

// 1. PUBLIC PAGES ROUTES
Route::get('/', [PagesController::class, 'home'])->name('home');
Route::get('/profil', [PagesController::class, 'profil'])->name('profil');
Route::get('/kursus', [PagesController::class, 'kursus'])->name('kursus');
Route::get('/news', [PagesController::class, 'news'])->name('news');
Route::get('/news/{id}', [PagesController::class, 'newsDetail'])->name('news.detail');

// 2. GUEST / AUTHENTICATION ROUTES
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Password Reset Routes
    Route::get('/forgot-password', [AuthController::class, 'forgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'resetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// 3. COMMON AUTH ROUTE (REDIRECTS BASED ON ROLE)
Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard')->middleware('auth');

// 4. STUDENT / SISWA ROUTES (ROLE = 'siswa')
Route::middleware(['auth'])->group(function () {
    // We can secure role in controller or custom middleware.
    // Let's enforce it cleanly in controllers for maximum reliability.
    Route::get('/pendaftaran', [RegistrationController::class, 'form'])->name('pendaftaran');
    Route::post('/pendaftaran', [RegistrationController::class, 'submit'])->name('pendaftaran.submit');
    Route::post('/pendaftaran/{id}/cancel', [RegistrationController::class, 'cancel'])->name('pendaftaran.cancel');
    Route::get('/pendaftaran/bukti', [RegistrationController::class, 'bukti'])->name('pendaftaran.bukti');
    Route::get('/dashboard/siswa', [RegistrationController::class, 'dashboard'])->name('dashboard.siswa');
});

// 5. ADMIN ROUTES (ROLE = 'admin')
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/admin', [AdminController::class, 'dashboard'])->name('dashboard.admin');
    Route::get('/admin/rekap/pdf', [AdminController::class, 'printRekapPdf'])->name('admin.rekap.pdf');
    Route::get('/admin/rekap/excel', [AdminController::class, 'exportRekapExcel'])->name('admin.rekap.excel');
    Route::post('/admin/registrations/{id}/action', [AdminController::class, 'processRegistration'])->name('admin.registrations.action');
    Route::post('/admin/registrations/{id}/delete', [AdminController::class, 'destroyRegistration'])->name('admin.registrations.delete');
    
    // CMS Settings
    Route::post('/admin/settings/update', [AdminController::class, 'updateSettings'])->name('admin.settings.update');
    
    // Courses CRUD
    Route::post('/admin/courses', [AdminController::class, 'storeCourse'])->name('admin.courses.store');
    Route::post('/admin/courses/{id}/update', [AdminController::class, 'updateCourse'])->name('admin.courses.update');
    Route::post('/admin/courses/{id}/delete', [AdminController::class, 'destroyCourse'])->name('admin.courses.delete');
    
    // News CRUD
    Route::post('/admin/news', [AdminController::class, 'storeNews'])->name('admin.news.store');
    Route::post('/admin/news/{id}/update', [AdminController::class, 'updateNews'])->name('admin.news.update');
    Route::post('/admin/news/{id}/delete', [AdminController::class, 'destroyNews'])->name('admin.news.delete');
    
    // Gallery CRUD
    Route::post('/admin/gallery', [AdminController::class, 'storeGallery'])->name('admin.gallery.store');
    Route::post('/admin/gallery/{id}/delete', [AdminController::class, 'destroyGallery'])->name('admin.gallery.delete');
});

// Route khusus untuk melayani file dari storage/app/public via query string (mengatasi %2F 404 Not Found dan isu symlink 403)
Route::get('/berkas', function (\Illuminate\Http\Request $request) {
    $path = $request->query('file');
    
    if (!$path || !\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
        abort(404, 'Dokumen tidak ditemukan di server.');
    }
    
    $filePath = \Illuminate\Support\Facades\Storage::disk('public')->path($path);
    $mimeType = mime_content_type($filePath);
    
    return response()->file($filePath, [
        'Content-Type' => $mimeType,
        'Content-Disposition' => 'inline; filename="'.basename($filePath).'"'
    ]);
})->name('berkas');
