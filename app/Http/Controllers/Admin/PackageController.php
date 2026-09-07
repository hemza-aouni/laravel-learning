<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PackageController extends Controller
{
    public function store(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect('/admin/login');
        }

        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'type'        => 'required|in:monthly,yearly,lifetime',
            'price'       => 'required|numeric|min:0',
            'currency'    => 'nullable|string|max:10',
            'trial_days'  => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'features'    => 'nullable|string',
            'is_active'   => 'nullable|boolean',
        ]);

        $data['slug'] = Str::slug($data['name']) . '-' . time();
        $data['currency'] = $data['currency'] ?? 'USD';
        $data['trial_days'] = $data['trial_days'] ?? 0;
        $data['is_active'] = $request->boolean('is_active', true);

        if (!empty($data['features'])) {
            $data['features'] = array_map('trim', explode("\n", $data['features']));
        }

        Package::create($data);

        return redirect('/admin/dashboard#section-packages')
            ->with('success', 'Package created successfully.');
    }

    public function update(Request $request, Package $package)
    {
        if (!session('admin_logged_in')) {
            return redirect('/admin/login');
        }

        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'type'        => 'required|in:monthly,yearly,lifetime',
            'price'       => 'required|numeric|min:0',
            'currency'    => 'nullable|string|max:10',
            'trial_days'  => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'features'    => 'nullable|string',
            'is_active'   => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        if (!empty($data['features'])) {
            $data['features'] = array_map('trim', explode("\n", $data['features']));
        }

        $package->update($data);

        return redirect('/admin/dashboard#section-packages')
            ->with('success', 'Package updated successfully.');
    }

    public function destroy(Package $package)
    {
        if (!session('admin_logged_in')) {
            return redirect('/admin/login');
        }

        $package->delete();

        return redirect('/admin/dashboard#section-packages')
            ->with('success', 'Package deleted successfully.');
    }
}
