<header class="bg-slate-900 border-b border-slate-800 px-6 py-4 flex justify-between items-center">
    <a href="/" class="font-black text-lg text-rose-500">SaaSPlatform</a>

    <nav class="hidden md:flex space-x-6 text-sm font-semibold text-slate-300">
        @foreach(\App\Models\MenuItem::where('location', 'header')->orderBy('order')->get() as $item)
            <a href="{{ $item->resolved_url }}" class="hover:text-white transition">{{ $item->label }}</a>
        @endforeach
    </nav>

    <div class="flex items-center space-x-3">
        <a href="/deploy" class="bg-emerald-600 hover:bg-emerald-500 text-white px-4 py-2 rounded-xl text-xs font-semibold">Deploy Hotel</a>
        <a href="/admin/login" class="bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2 rounded-xl text-xs font-semibold">Admin Login</a>
    </div>
</header>
