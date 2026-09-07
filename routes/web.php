<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Tenant;
use App\Models\Article;
use App\Models\Category;
use App\Models\Page;
use App\Models\MenuItem;
use App\Models\Setting;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\TenantFrontController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\SettingController;

Route::get('/', function () {
    $latestArticles = Article::published()->latest('published_at')->take(3)->get();
    return view('welcome', compact('latestArticles'));
});

Route::get('/deploy', function () { return view('tenant-register'); });

Route::post('/register-hotel', function (Request $request) {
    $request->validate([
        'hotel_name' => 'required|string|max:255',
        'subdomain' => 'required|string|alpha_dash|unique:tenants,id',
        'email' => 'required|email',
        'password' => 'required|digits:4',
    ]);

    $tenant = Tenant::withoutEvents(function () use ($request) {
        return Tenant::create([
            'id' => $request->subdomain,
            'hotel_name' => $request->hotel_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'trial_ends_at' => now()->addDay(),
            'subscription_status' => 'trial',
        ]);
    });

    return redirect()->to('/hotel/' . $request->subdomain);
});

Route::get('/hotel/{id}', function ($id) {
    $tenant = Tenant::findOrFail($id);
    return view('tenant.dashboard', compact('tenant'));
});

Route::get('/hotel/{id}/preview', [TenantFrontController::class, 'show']);

// -------- Public Blog --------
Route::get('/blog', function () {
    $categories = Category::orderBy('name')->get();
    $articles = Article::published()->with('category')->latest('published_at')->paginate(9);
    return view('blog.index', compact('articles', 'categories'));
})->name('blog.index');

Route::get('/blog/{slug}', function ($slug) {
    $article = Article::where('slug', $slug)->published()->firstOrFail();
    $latest = Article::published()->where('id', '!=', $article->id)->latest('published_at')->take(3)->get();
    return view('blog.show', compact('article', 'latest'));
})->name('blog.show');

// -------- Public Pages (Privacy / Terms / About / Contact / custom) --------
Route::get('/page/{slug}', function ($slug) {
    $page = Page::where('slug', $slug)->firstOrFail();
    return view('page.show', compact('page'));
})->name('page.show');

// -------- Admin Auth --------
Route::get('/admin/login', function () { return view('admin.login'); });
Route::post('/admin/login', function (Request $request) {
    if ($request->password === '1234') {
        session(['admin_logged_in' => true]);
        return redirect('/admin/dashboard');
    }
    return back()->withErrors(['password' => 'Invalid Admin PIN']);
});
Route::get('/admin/logout', function () {
    session()->forget('admin_logged_in');
    return redirect('/admin/login');
});

// -------- Admin Dashboard --------
Route::get('/admin/dashboard', function () {
    if (!session('admin_logged_in')) { return redirect('/admin/login'); }

    $tenants = Tenant::all();
    $categories = Category::withCount('articles')->orderBy('name')->get();
    $articles = Article::with('category')->latest()->get();
    $pages = Page::orderBy('title')->get();
    $headerMenu = MenuItem::where('location', 'header')->orderBy('order')->get();
    $footerMenu = MenuItem::where('location', 'footer')->orderBy('order')->get();
    $footerCopyright = Setting::get('footer_copyright', 'All Rights Reserved © ' . date('Y'));

    return view('admin.dashboard', compact(
        'tenants', 'categories', 'articles', 'pages', 'headerMenu', 'footerMenu', 'footerCopyright'
    ));
});

Route::delete('/admin/tenants/{id}', function ($id) {
    if (!session('admin_logged_in')) { return redirect('/admin/login'); }
    Tenant::findOrFail($id)->delete();
    return redirect('/admin/dashboard#section-users')->with('success', 'Tenant deleted.');
});

// -------- Admin: Blog (Categories & Articles) --------
Route::middleware('web')->group(function () {
    Route::post('/admin/blog/categories', [CategoryController::class, 'store']);
    Route::put('/admin/blog/categories/{category}', [CategoryController::class, 'update']);
    Route::delete('/admin/blog/categories/{category}', [CategoryController::class, 'destroy']);

    Route::post('/admin/blog/articles', [ArticleController::class, 'store']);
    Route::get('/admin/blog/articles/{article}/edit', [ArticleController::class, 'edit']);
    Route::put('/admin/blog/articles/{article}', [ArticleController::class, 'update']);
    Route::delete('/admin/blog/articles/{article}', [ArticleController::class, 'destroy']);
});

// -------- Admin: Pages --------
Route::post('/admin/pages', [PageController::class, 'store']);
Route::get('/admin/pages/{page}/edit', [PageController::class, 'edit']);
Route::put('/admin/pages/{page}', [PageController::class, 'update']);
Route::delete('/admin/pages/{page}', [PageController::class, 'destroy']);

// -------- Admin: Menu (Header/Footer links) --------
Route::post('/admin/menu', [MenuController::class, 'store']);
Route::delete('/admin/menu/{menuItem}', [MenuController::class, 'destroy']);

// -------- Admin: Footer settings --------
Route::post('/admin/footer', [SettingController::class, 'updateFooter']);

// -------- Admin: Payment settings (unchanged) --------
Route::post('/admin/settings/payment', function (Request $request) {
    if (!session('admin_logged_in')) { return redirect('/admin/login'); }
    return redirect('/admin/dashboard#section-settings')->with('success', 'Gateway settings updated.');
});
Route::post('/admin/domains/store', function (Request $request) {
    if (!session('admin_logged_in')) { return redirect('/admin/login'); }
    return back()->with('success', 'Domain request submitted.');
});
