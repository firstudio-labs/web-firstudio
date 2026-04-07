<?php

use Illuminate\Support\Facades\Route;

// Admin Controllers
use App\Http\Controllers\Admin\ArtikelController;
use App\Http\Controllers\Admin\BerandaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\Admin\KategoriArtikelController;
use App\Http\Controllers\Admin\KategoriGambarController;
use App\Http\Controllers\Admin\KategoriProdukController;
use App\Http\Controllers\Admin\KomentarArtikelController;
use App\Http\Controllers\Admin\KontakController;
use App\Http\Controllers\Admin\LayananController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\ProfilController;
use App\Http\Controllers\Admin\TentangController;
use App\Http\Controllers\Admin\TestimoniController;
use App\Http\Controllers\Admin\TimController;
use App\Http\Controllers\Admin\SettingController;

// Auth Controllers
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// Web Controllers
use App\Http\Controllers\web\ChatbotController;
use App\Http\Controllers\web\WebArtikelController;
use App\Http\Controllers\web\WebBerandaController;
use App\Http\Controllers\web\WebKontakController;
use App\Http\Controllers\web\WebProdukController;
use App\Http\Controllers\web\WebTentangController;
use App\Http\Controllers\web\WebLayananController;
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

// ============================================================================
// Authentication Routes
// ============================================================================

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login.form');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    
    Route::get('/register', [RegisterController::class, 'index'])->name('register.form');
    Route::post('/register', [RegisterController::class, 'register'])->name('register');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// Route /dashboard untuk backward compatibility (redirect ke /admin/dashboard)
Route::get('/dashboard', function() {
    if (auth()->check() && auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('login.form');
})->middleware('auth');

// ============================================================================
// Admin Routes (Protected by auth and role middleware)
// Menggunakan prefix /admin/ untuk menghindari konflik dengan route public
// HARUS didefinisikan SEBELUM route public dengan parameter {slug}
// ============================================================================

Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    // Dashboard route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::delete('/dashboard/{user}', [DashboardController::class, 'destroy'])->name('dashboard.destroy');
    
    // Resource Routes
    Route::resource('beranda', BerandaController::class);
    Route::resource('artikel', ArtikelController::class);
    Route::resource('galeri', GaleriController::class);
    Route::resource('kontak', KontakController::class);
    Route::resource('layanan', LayananController::class);
    Route::resource('produk', ProdukController::class);
    Route::resource('profil', ProfilController::class);
    Route::resource('tentang', TentangController::class);
    Route::resource('testimoni', TestimoniController::class);
    Route::resource('tim', TimController::class);
    Route::resource('kategoriArtikel', KategoriArtikelController::class);
    Route::resource('komentarArtikel', KomentarArtikelController::class);
    Route::resource('kategoriProduk', KategoriProdukController::class);
    Route::resource('kategoriGambar', KategoriGambarController::class);
    Route::resource('template', \App\Http\Controllers\Admin\TemplateController::class);
    Route::resource('kategoriTemplate', \App\Http\Controllers\Admin\KategoriTemplateController::class);

    // Settings Route
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'store'])->name('settings.store');
    Route::post('/settings/test-ai', [SettingController::class, 'testAi'])->name('settings.test-ai');

    Route::prefix('chatbot')->name('chatbot.')->group(function () {
        Route::get('/sessions', [\App\Http\Controllers\Admin\ChatbotSessionController::class, 'index'])->name('sessions.index');
        Route::get('/sessions/{chatbotSession}', [\App\Http\Controllers\Admin\ChatbotSessionController::class, 'show'])->name('sessions.show');
        Route::post('/sessions/{chatbotSession}/respond', [\App\Http\Controllers\Admin\ChatbotSessionController::class, 'respond'])->name('sessions.respond');

        Route::resource('faq', \App\Http\Controllers\Admin\ChatbotFaqController::class)->except(['show']);
    });
    
    // AI Generated Routes (with additional middleware)
    Route::middleware('ai.access')->group(function () {
        Route::post('/artikel/generate-ai', [ArtikelController::class, 'generateAI'])->name('artikel.generate-ai');
        Route::post('/artikel/generate-titles', [ArtikelController::class, 'generateTitles'])->name('artikel.generate-titles');
        Route::post('/artikel/enhance-content', [ArtikelController::class, 'enhanceContent'])->name('artikel.enhance-content');
        Route::post('/produk/generate-deskripsi', [ProdukController::class, 'generateDeskripsi'])->name('produk.generate-deskripsi');
    });
});

// ============================================================================
// Public Routes (Dapat diakses oleh guest maupun authenticated user)
// HARUS didefinisikan SETELAH route admin untuk menghindari konflik
// ============================================================================

Route::get('/', [WebBerandaController::class, 'index'])->name('web.beranda.index');

Route::prefix('artikel')->name('web.artikel.')->group(function () {
    Route::get('/', [WebArtikelController::class, 'index'])->name('index');
    Route::get('/{slug}', [WebArtikelController::class, 'show'])->name('show');
});

Route::prefix('portofolio')->name('web.produk.')->group(function () {
    Route::get('/', [WebProdukController::class, 'index'])->name('index');
    Route::get('/{slug}', [WebProdukController::class, 'show'])->name('show');
});

Route::prefix('contact')->name('web.contact.')->group(function () {
    Route::get('/', [WebKontakController::class, 'index'])->name('index');
    Route::post('/', [WebKontakController::class, 'store'])->name('store');
});

Route::post('/chatbot', ChatbotController::class)
    ->name('web.chatbot.ask')
    ->middleware('throttle:30,1');

Route::get('/about', [WebTentangController::class, 'index'])->name('web.about.index');

Route::prefix('layanan')->name('web.layanan.')->group(function () {
    Route::get('/website', [WebLayananController::class, 'website'])->name('website');
    Route::get('/website/katalog', [WebLayananController::class, 'katalog'])->name('website.katalog');
    Route::get('/mobile', [WebLayananController::class, 'mobile'])->name('mobile');
    Route::get('/itconsul', [WebLayananController::class, 'itconsul'])->name('itconsul');
    Route::get('/company', [WebLayananController::class, 'company'])->name('company');
    Route::get('/itoutsourcing', [WebLayananController::class, 'itoutsourcing'])->name('itoutsourcing');
});