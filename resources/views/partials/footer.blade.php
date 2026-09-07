<footer class="bg-slate-950 border-t border-slate-800 py-10 px-6">
    <div class="max-w-6xl mx-auto flex flex-col md:flex-row justify-between items-center gap-6">
        <p class="text-xs text-slate-500">{{ \App\Models\Setting::get('footer_copyright', 'All Rights Reserved © ' . date('Y')) }}</p>
        <div class="flex flex-wrap gap-4">
            @foreach(\App\Models\MenuItem::where('location','footer')->orderBy('order')->get() as $item)
                <a href="{{ $item->resolved_url }}" class="text-xs text-slate-400 hover:text-white transition">{{ $item->label }}</a>
            @endforeach
        </div>
    </div>
</footer>
