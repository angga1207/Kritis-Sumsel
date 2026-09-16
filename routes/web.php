<?php

use App\Http\Controllers\PublicController;
use App\Livewire\Actions\Logout;
use App\Livewire\Admin\Analytics;
use App\Livewire\Admin\ArticleForm;
use App\Livewire\Admin\ArticleManager;
use App\Livewire\Admin\CategoryManager;
use App\Livewire\Admin\CommentModeration;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\SettingsManager;
use App\Livewire\Admin\TagManager;
use App\Livewire\Admin\UserManager;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/kategori/{slug}', [PublicController::class, 'categoryShow'])->name('category.show');
Route::get('/tag/{slug}', [PublicController::class, 'tagShow'])->name('tag.show');
Route::get('/artikel/{slug}', [PublicController::class, 'articleShow'])->name('article.show');
Route::get('/cari', [PublicController::class, 'search'])->name('search');
Route::get('/penulis/{username}', [PublicController::class, 'authorShow'])->name('author.show');

Route::get('/tentang-kami', [PublicController::class, 'about'])->name('page.about');
Route::get('/redaksi', [PublicController::class, 'redaksi'])->name('page.redaksi');
Route::get('/kontak', [PublicController::class, 'contact'])->name('page.contact');
Route::get('/kebijakan-privasi', [PublicController::class, 'privacy'])->name('page.privacy');
Route::get('/newsletter/verify/{token}', [PublicController::class, 'newsletterVerify'])->name('newsletter.verify');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::post('logout', function (Logout $logout) {
    $logout();

    return redirect('/');
})->middleware('auth')->name('logout');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');

    Route::middleware('permission:articles.viewAny')->group(function () {
        Route::get('/artikel', ArticleManager::class)->name('articles.index');
        Route::get('/artikel/baru', ArticleForm::class)->name('articles.create');
        Route::get('/artikel/{article}/edit', ArticleForm::class)->name('articles.edit');
        Route::get('/analitik', Analytics::class)->name('analytics.index');
    });

    Route::middleware('permission:categories.manage')->group(function () {
        Route::get('/kategori', CategoryManager::class)->name('categories.index');
        Route::get('/tag', TagManager::class)->name('tags.index');
    });

    Route::middleware('permission:comments.moderate')->group(function () {
        Route::get('/komentar', CommentModeration::class)->name('comments.index');
    });

    Route::middleware('permission:users.manage')->group(function () {
        Route::get('/pengguna', UserManager::class)->name('users.index');
    });

    Route::middleware('permission:settings.manage')->group(function () {
        Route::get('/pengaturan', SettingsManager::class)->name('settings.index');
    });
});

require __DIR__.'/auth.php';
