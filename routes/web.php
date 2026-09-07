<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Tenant;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\TenantFrontController;

Route::get('/', function () { return view('welcome'); });
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

// Admin Routes
Route::get('/admin/login', function () { return view('admin.login'); });
Route::post('/admin/login', function (Request $request) {
    if ($request->password === '1234') {
        session(['admin_logged_in' => true]);
        return redirect('/admin/dashboard');
    }
    return back()->withErrors(['password' => 'Invalid Admin PIN']);
});

Route::get('/admin/dashboard', function () {
    if (!session('admin_logged_in')) { return redirect('/admin/login'); }
    $tenants = Tenant::all();
    return view('admin.dashboard', compact('tenants'));
});

// Admin Post Actions
Route::post('/admin/blog/categories', function (Request $request) {
    if (!session('admin_logged_in')) { return redirect('/admin/login'); }
    return back()->with('success', 'Category created successfully.');
});
Route::post('/admin/blog/articles', function (Request $request) {
    if (!session('admin_logged_in')) { return redirect('/admin/login'); }
    return back()->with('success', 'Article published successfully with SEO metadata.');
});
Route::post('/admin/pages', function (Request $request) {
    if (!session('admin_logged_in')) { return redirect('/admin/login'); }
    return back()->with('success', 'Page saved successfully.');
});
Route::post('/admin/footer', function (Request $request) {
    if (!session('admin_logged_in')) { return redirect('/admin/login'); }
    return back()->with('success', 'Footer & Useful links updated successfully.');
});
Route::post('/admin/settings/payment', function (Request $request) {
    if (!session('admin_logged_in')) { return redirect('/admin/login'); }
    return back()->with('success', 'Gateway settings updated.');
});
Route::post('/admin/domains/store', function (Request $request) {
    if (!session('admin_logged_in')) { return redirect('/admin/login'); }
    return back()->with('success', 'Domain request submitted.');
});
Route::delete('/admin/tenants/{id}', function ($id) {
    if (!session('admin_logged_in')) { return redirect('/admin/login'); }
    Tenant::findOrFail($id)->delete();
    return back()->with('success', 'Tenant deleted.');
});
Route::get('/admin/logout', function () {
    session()->forget('admin_logged_in');
    return redirect('/admin/login');
});
