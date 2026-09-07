<header class="bg-slate-900/95 backdrop-blur-md border-b border-slate-800 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <!-- Logo -->
        <a href="/" class="font-black text-xl text-rose-500 tracking-tight">SaaSPlatform</a>

        <!-- Desktop Nav -->
        <nav class="hidden md:flex items-center space-x-8 text-sm font-semibold text-slate-300">
            <a href="/" class="hover:text-white transition">Home</a>
            <a href="/blog" class="hover:text-white transition">Blog</a>
            <a href="/#pricing" class="hover:text-white transition">Pricing</a>
            <a href="/contact" class="hover:text-white transition">Contact Us</a>
        </nav>

        <!-- Right side -->
        <div class="flex items-center space-x-3">
            <a href="/admin/login" class="hidden sm:inline-flex bg-indigo-600/20 hover:bg-indigo-600/30 text-indigo-400 border border-indigo-500/30 px-4 py-2.5 rounded-xl text-xs font-semibold transition">
                Admin
            </a>

            <!-- Mobile Hamburger Button -->
            <button id="mobile-menu-btn" onclick="document.getElementById('mobile-nav').classList.toggle('hidden')" 
                    class="md:hidden text-slate-300 hover:text-white p-2 focus:outline-none">
                <i class="fa-solid fa-bars text-xl"></i>
            </button>
        </div>
    </div>

    <!-- Mobile Navigation Drawer -->
    <div id="mobile-nav" class="hidden md:hidden border-t border-slate-800 bg-slate-900">
        <nav class="flex flex-col px-6 py-4 space-y-1 text-sm font-semibold text-slate-300">
            <a href="/" class="px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition">Home</a>
            <a href="/blog" class="px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition">Blog</a>
            <a href="/#pricing" class="px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition">Pricing</a>
            <a href="/contact" class="px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition">Contact Us</a>
            <a href="/admin/login" class="px-4 py-3 rounded-xl hover:bg-slate-800 text-indigo-400 transition">Admin Login</a>
        </nav>
    </div>
</header>
