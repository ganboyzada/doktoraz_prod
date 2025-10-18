<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\TranslationController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductVariantController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\PageMetaController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\SocialPostController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\InnocomController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\FaqController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Innosoft 2023 - Routes
|--------------------------------------------------------------------------
*/

// Front Site

Route::get('/lang/{code}', [FrontController::class, 'switchLang'])->name('langswitch');
Route::get('/sitemap', [FrontController::class, 'sitemap'])->name('sitemap');

// $languages = config('app.available_locales');
$languages = ['az','ru'];

Route::get('/', function () {
    $default = config('app.locale'); // fallback to az
    return redirect()->to($default);
});

foreach ($languages as $lang) {
    Route::group([
        'prefix' => $lang,
        'middleware' => 'lang:' . $lang
    ], function () use ($lang) {
        Route::get('/', [FrontController::class, 'home'])->name("home.$lang");
        Route::get('/xidmetler', [FrontController::class, 'services'])->name("services.$lang");
        Route::get('/xidmetler/{slug}', [FrontController::class, 'service'])->name("services.find.$lang");
        Route::get('/hekimler', [FrontController::class, 'doctors'])->name("doctors.$lang");
        Route::get('/hekimler/{slug}', [FrontController::class, 'doctor'])->name("doctors.find.$lang");
        Route::get('/xeberler', [FrontController::class, 'blog'])->name("news.$lang");
        Route::get('/xeberler/{slug}', [FrontController::class, 'blogpost'])->name("news.find.$lang");
        Route::get('/haqqimizda', [FrontController::class, 'about_us'])->name("about_us.$lang");
    });
}

// Admin Panel

Route::group(['prefix' => 'admin', 'middleware'=>['auth', 'inno']], function () {

    Route::get('/lang/{code}', [AdminController::class, 'switchLang'])->name('inno.langswitch');
    Route::get('/theme/{code}', [AdminController::class, 'switchTheme'])->name('inno.themeswitch');

    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resources([
        // 'clients' => ClientController::class,
        'projects' => ProjectController::class,
        'languages' => LanguageController::class,
        'translations' => TranslationController::class,
        'media' => MediaController::class,
        // 'branches' => BranchController::class,
        'departments' => DepartmentController::class,
        'categories' => CategoryController::class,
        // 'products' => ProductController::class,
        // 'product_variants' => ProductVariantController::class,
        // 'orders' => OrderController::class,
        'blogs' => BlogController::class,
        // 'faqs' => FaqController::class,
        'socials' => SocialController::class,
        // 'social_posts' => SocialPostController::class,
        'members' => MemberController::class,
        // 'tasks' => TaskController::class,
        'slides' => SlideController::class,
        // 'gallery' => GalleryController::class,
        'contents' => ContentController::class,
        'page_metas' => PageMetaController::class,
        'settings' => SettingController::class,
    ]);
});

// Login, Logout directory

require __DIR__.'/auth.php';
