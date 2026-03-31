<?php

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ContentController;
use App\Http\Controllers\Backend\GuestRegistrationController;
use App\Http\Controllers\Backend\MenuController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\HomeController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/thumoi', 'thumoi')->name('thumoi');
Route::post('/rsvp', [HomeController::class, 'storeRsvp'])->name('home.rsvp');
Route::get('/login', function () {
    return redirect()->route('backend.admin.login');
})->name('login');

Route::prefix('admin')->name('backend.')->group(function () {
    Route::name('admin.')->group(function () {
        Route::get('login', [AdminController::class, 'login'])->name('login');
        Route::post('login', [AdminController::class, 'authenticate'])->name('authenticate');
        Route::post('logout', [AdminController::class, 'logout'])->name('logout');
    });

    Route::middleware('auth')->group(function () {
        Route::name('admin.')->group(function () {
            Route::get('/', [AdminController::class, 'index'])->name('dashboard');
        });

        Route::resource('categories', CategoryController::class)
            ->except(['show'])
            ->names('categories');
        Route::patch('categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])
            ->name('categories.toggle-status');

        Route::prefix('products')->name('products.')->group(function () {
            Route::get('/', [ContentController::class, 'productIndex'])->name('index');
            Route::get('create', [ContentController::class, 'productCreate'])->name('create');
            Route::post('/', [ContentController::class, 'productStore'])->name('store');
            Route::get('{post}/edit', [ContentController::class, 'productEdit'])->name('edit');
            Route::put('{post}', [ContentController::class, 'productUpdate'])->name('update');
            Route::delete('{post}', [ContentController::class, 'productDestroy'])->name('destroy');
            Route::patch('{post}/toggle-status', [ContentController::class, 'productToggleStatus'])->name('toggle-status');
        });

        Route::prefix('news')->name('news.')->group(function () {
            Route::get('/', [ContentController::class, 'newsIndex'])->name('index');
            Route::get('create', [ContentController::class, 'newsCreate'])->name('create');
            Route::post('/', [ContentController::class, 'newsStore'])->name('store');
            Route::get('{post}/edit', [ContentController::class, 'newsEdit'])->name('edit');
            Route::put('{post}', [ContentController::class, 'newsUpdate'])->name('update');
            Route::delete('{post}', [ContentController::class, 'newsDestroy'])->name('destroy');
            Route::patch('{post}/toggle-status', [ContentController::class, 'newsToggleStatus'])->name('toggle-status');
        });

        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/', [SettingController::class, 'edit'])->name('edit');
            Route::put('/', [SettingController::class, 'update'])->name('update');
        });

        Route::resource('menus', MenuController::class)
            ->except(['show'])
            ->names('menus');
        Route::patch('menus/{menu}/toggle-status', [MenuController::class, 'toggleStatus'])
            ->name('menus.toggle-status');
        Route::patch('menus/{menu}/sort-order', [MenuController::class, 'updateSortOrder'])
            ->name('menus.update-sort-order');

        Route::resource('users', UserController::class)
            ->except(['show'])
            ->names('users');
        Route::get('guest-registrations', [GuestRegistrationController::class, 'index'])
            ->name('guest-registrations.index');
        Route::delete('guest-registrations/{guestRegistration}', [GuestRegistrationController::class, 'destroy'])
            ->name('guest-registrations.destroy');

        Route::post('uploads/editor-image', [ContentController::class, 'uploadEditorImage'])
            ->name('admin.uploads.editor-image');
    });
});
