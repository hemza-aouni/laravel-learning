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
    if (!session('admin_logged_in')) {
        return redirect('/admin/login');
    }

    $tenants = \App\Models\Tenant::all();
    $packages = \App\Models\Package::orderBy('sort_order')->get();
    $coupons = \App\Models\Coupon::orderByDesc('created_at')->get();
    $gateways = \App\Models\PaymentGateway::all();
    $categories = class_exists(\App\Models\Category::class) ? \App\Models\Category::all() : collect([]);
    $articles = class_exists(\App\Models\Article::class) ? \App\Models\Article::latest()->take(20)->get() : collect([]);

    $appearance = (object)[];
    $path = storage_path('app/appearance.json');
    if (file_exists($path)) {
        $data = json_decode(file_get_contents($path), true);
        if (is_array($data)) $appearance = (object)$data;
    }

    return view('admin.dashboard', compact(
        'tenants', 'packages', 'coupons', 'gateways',
        'categories', 'articles', 'appearance'
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

// ========== Appearance Routes ==========

Route::post('/admin/appearance/cta', function (Request $request) {
    if (!session('admin_logged_in')) return redirect('/admin/login');
    return redirect('/admin/dashboard#section-appearance')->with('success', 'CTA section updated successfully.');
});
Route::post('/admin/appearance/video', function (Request $request) {
    if (!session('admin_logged_in')) return redirect('/admin/login');
    return redirect('/admin/dashboard#section-appearance')->with('success', 'Video section updated successfully.');
});
Route::post('/admin/appearance/testimonials', function (Request $request) {
    if (!session('admin_logged_in')) return redirect('/admin/login');
    return redirect('/admin/dashboard#section-appearance')->with('success', 'Testimonials updated successfully.');
});

// تحديث redirects القديمة
Route::post('/admin/blog/categories', function (Request $request) {
    if (!session('admin_logged_in')) return redirect('/admin/login');
    return redirect('/admin/dashboard#section-blog')->with('success', 'Category created successfully.');
});
Route::post('/admin/blog/articles', function (Request $request) {
    if (!session('admin_logged_in')) return redirect('/admin/login');
    return redirect('/admin/dashboard#section-blog')->with('success', 'Article published successfully.');
});
Route::post('/admin/pages', function (Request $request) {
    if (!session('admin_logged_in')) return redirect('/admin/login');
    return redirect('/admin/dashboard#section-pages')->with('success', 'Page saved successfully.');
});
Route::post('/admin/footer', function (Request $request) {
    if (!session('admin_logged_in')) return redirect('/admin/login');
    return redirect('/admin/dashboard#section-pages')->with('success', 'Footer updated successfully.');
});
Route::post('/admin/settings/payment', function (Request $request) {
    if (!session('admin_logged_in')) return redirect('/admin/login');
    return redirect('/admin/dashboard#section-settings')->with('success', 'Gateway settings updated.');
});
Route::delete('/admin/tenants/{id}', function ($id) {
    if (!session('admin_logged_in')) return redirect('/admin/login');
    \App\Models\Tenant::findOrFail($id)->delete();
    return redirect('/admin/dashboard#section-users')->with('success', 'Tenant deleted.');
});




// ========== حفظ Hero مع رفع الصورة ==========
Route::post('/admin/appearance/hero', function (\Illuminate\Http\Request $request) {
    if (!session('admin_logged_in')) {
        return redirect('/admin/login');
    }

    $path = storage_path('app/appearance.json');
    $current = [];
    if (file_exists($path)) {
        $current = json_decode(file_get_contents($path), true) ?: [];
    }

    $current['hero_title']     = $request->input('hero_title', $current['hero_title'] ?? 'Launch Your Hotel in Minutes');
    $current['hero_subtitle']  = $request->input('hero_subtitle', $current['hero_subtitle'] ?? '');
    $current['hero_btn_text']  = $request->input('hero_btn_text', $current['hero_btn_text'] ?? 'Deploy Your Hotel Now');
    $current['hero_btn_link']  = $request->input('hero_btn_link', $current['hero_btn_link'] ?? '/deploy');
    $current['hero_btn2_text'] = $request->input('hero_btn2_text', $current['hero_btn2_text'] ?? 'Explore Features');
    $current['hero_btn2_link'] = $request->input('hero_btn2_link', $current['hero_btn2_link'] ?? '/#features');

    // رفع الصورة
    if ($request->hasFile('hero_image') && $request->file('hero_image')->isValid()) {
        $file = $request->file('hero_image');
        $ext  = strtolower($file->getClientOriginalExtension());
        $allowed = ['jpg','jpeg','png','webp','gif'];
        if (in_array($ext, $allowed)) {
            $filename = 'hero_' . time() . '.' . $ext;
            $file->move(public_path('assets/uploads'), $filename);
            $current['hero_image'] = 'assets/uploads/' . $filename;
        }
    }

    file_put_contents($path, json_encode($current, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    return redirect('/admin/dashboard#section-appearance')
           ->with('success', 'Hero updated successfully' . (isset($current['hero_image']) ? ' — Image saved!' : ''));
});


// ========== الصفحة الرئيسية (Appearance + Latest Articles) ==========
Route::get('/', function () {
    // Appearance
    $appearance = (object) [];
    $path = storage_path('app/appearance.json');
    if (file_exists($path)) {
        $data = json_decode(file_get_contents($path), true);
        if (is_array($data)) {
            $appearance = (object) $data;
        }
    }

    // Latest Articles
    $latestArticles = collect([]);
    try {
        if (class_exists(\App\Models\Article::class)) {
            $latestArticles = \App\Models\Article::with('category')
                ->whereNotNull('published_at')
                ->orderByDesc('published_at')
                ->take(6)
                ->get();
        }
    } catch (\Throwable $e) {
        // إذا لم يكن الموديل موجوداً أو الجدول غير موجود نتركها فارغة
        $latestArticles = collect([]);
    }

    return view('welcome', compact('appearance', 'latestArticles'));
});


// ========== Package Management ==========
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\PaymentGatewayController;

Route::post('/admin/packages', [PackageController::class, 'store']);
Route::put('/admin/packages/{package}', [PackageController::class, 'update']);
Route::delete('/admin/packages/{package}', [PackageController::class, 'destroy']);

Route::post('/admin/coupons', [CouponController::class, 'store']);
Route::delete('/admin/coupons/{coupon}', [CouponController::class, 'destroy']);

Route::put('/admin/payment-gateways/{gateway}', [PaymentGatewayController::class, 'update']);

// ========== Checkout ==========
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Webhooks\StripeWebhookController;
use App\Http\Controllers\Webhooks\PaypalWebhookController;
use App\Http\Controllers\Webhooks\LemonSqueezyWebhookController;

Route::get('/checkout/{package}', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

// ========== Webhooks (يجب استثناؤها من CSRF) ==========
Route::post('/webhooks/stripe', [StripeWebhookController::class, 'handle'])->name('webhooks.stripe');
Route::post('/webhooks/paypal', [PaypalWebhookController::class, 'handle'])->name('webhooks.paypal');
Route::post('/webhooks/lemonsqueezy', [LemonSqueezyWebhookController::class, 'handle'])->name('webhooks.lemonsqueezy');
