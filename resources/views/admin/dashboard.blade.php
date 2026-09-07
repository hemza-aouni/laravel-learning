<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Control Center | SaaS Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.3/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '.rich-editor',
            plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table',
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat',
            skin: 'oxide-dark',
            content_css: 'dark',
            height: 250
        });

        function toggleMobileMenu() {
            document.getElementById('mobile-sidebar').classList.toggle('hidden');
        }
        function switchTab(tabId) {
            document.querySelectorAll('.admin-section').forEach(el => el.classList.add('hidden'));
            document.getElementById(tabId).classList.remove('hidden');
            document.getElementById('mobile-sidebar').classList.add('hidden');
        }
        function switchBlogSubTab(subTabId) {
            document.querySelectorAll('.blog-sub-section').forEach(el => el.classList.add('hidden'));
            document.getElementById(subTabId).classList.remove('hidden');
        }
        function toggleLinkType(formPrefix) {
            const type = document.getElementById(formPrefix + '-link-type').value;
            document.getElementById(formPrefix + '-url-field').classList.toggle('hidden', type !== 'url');
            document.getElementById(formPrefix + '-page-field').classList.toggle('hidden', type !== 'page');
        }
    </script>
</head>
<body class="bg-slate-950 text-slate-100 font-sans antialiased min-h-screen flex flex-col">

    <header class="bg-slate-900 border-b border-slate-800 sticky top-0 z-50 px-6 py-4 flex justify-between items-center">
        <div class="flex items-center space-x-4">
            <div class="bg-rose-600 p-2.5 rounded-xl text-white shadow-lg shadow-rose-600/30">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <div>
                <span class="font-black text-lg tracking-wide">SaaS Master Admin</span>
                <span class="hidden sm:inline-block text-xs text-slate-400 ml-2">| Global Infrastructure</span>
            </div>
        </div>

        <nav class="hidden lg:flex items-center space-x-1 text-sm font-semibold">
            <button onclick="switchTab('section-dashboard')" class="px-3.5 py-2 rounded-xl hover:bg-slate-800 text-slate-300 transition">Dashboard</button>
            <button onclick="switchTab('section-users')" class="px-3.5 py-2 rounded-xl hover:bg-slate-800 text-slate-300 transition">Registered Users</button>
            <button onclick="switchTab('section-blog')" class="px-3.5 py-2 rounded-xl hover:bg-slate-800 text-slate-300 transition">Blog & Articles</button>
            <button onclick="switchTab('section-pages')" class="px-3.5 py-2 rounded-xl hover:bg-slate-800 text-slate-300 transition">Pages & Menu</button>
            <button onclick="switchTab('section-domains')" class="px-3.5 py-2 rounded-xl hover:bg-slate-800 text-slate-300 transition">Domains</button>
            <button onclick="switchTab('section-settings')" class="px-3.5 py-2 rounded-xl hover:bg-slate-800 text-slate-300 transition">Gateways</button>
        </nav>

        <div class="flex items-center space-x-3">
            <a href="/" target="_blank" title="Preview Public Website" class="bg-indigo-600/20 hover:bg-indigo-600/30 text-indigo-400 border border-indigo-500/30 p-2.5 rounded-xl transition flex items-center space-x-2 text-xs font-semibold px-3">
                <i class="fa-solid fa-eye text-sm"></i>
                <span class="hidden sm:inline">Preview Site</span>
            </a>
            <a href="/admin/logout" class="bg-slate-800 hover:bg-slate-700 text-rose-400 px-3 py-2.5 rounded-xl text-xs font-semibold transition flex items-center space-x-2">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span class="hidden sm:inline">Logout</span>
            </a>
            <button onclick="toggleMobileMenu()" class="lg:hidden text-slate-300 hover:text-white p-2 focus:outline-none">
                <i class="fa-solid fa-bars text-xl"></i>
            </button>
        </div>
    </header>

    <div id="mobile-sidebar" class="hidden lg:hidden fixed inset-0 z-40 bg-slate-950/80 backdrop-blur-md pt-20 px-6">
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-4 shadow-2xl">
            <div class="flex justify-between items-center pb-4 border-b border-slate-800">
                <span class="font-bold text-sm text-slate-400">Navigation Menu</span>
                <button onclick="toggleMobileMenu()" class="text-slate-400 hover:text-white"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>
            <div class="flex flex-col space-y-2 text-sm font-semibold">
                <button onclick="switchTab('section-dashboard')" class="text-left px-4 py-3 rounded-xl hover:bg-slate-800">Dashboard & Stats</button>
                <button onclick="switchTab('section-users')" class="text-left px-4 py-3 rounded-xl hover:bg-slate-800">Registered Users (Tenants)</button>
                <button onclick="switchTab('section-blog')" class="text-left px-4 py-3 rounded-xl hover:bg-slate-800">Blog & Articles</button>
                <button onclick="switchTab('section-pages')" class="text-left px-4 py-3 rounded-xl hover:bg-slate-800">Pages & Menu</button>
                <button onclick="switchTab('section-domains')" class="text-left px-4 py-3 rounded-xl hover:bg-slate-800">Domains Management</button>
                <button onclick="switchTab('section-settings')" class="text-left px-4 py-3 rounded-xl hover:bg-slate-800">Payment Gateways</button>
            </div>
        </div>
    </div>

    <main class="flex-1 max-w-7xl w-full mx-auto p-6 md:p-10 space-y-8">

        @if(session('success'))
            <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 p-4 rounded-2xl text-sm flex items-center space-x-3">
                <i class="fa-solid fa-circle-check text-lg"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if($errors->any())
            <div class="bg-rose-500/10 border border-rose-500/20 text-rose-400 p-4 rounded-2xl text-sm">
                <ul class="list-disc pr-5">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <!-- ================= 1. DASHBOARD ================= -->
        <div id="section-dashboard" class="admin-section space-y-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-slate-900 border border-slate-800 p-6 rounded-2xl gap-4">
                <div>
                    <h1 class="text-2xl font-black">Admin Overview Dashboard</h1>
                    <p class="text-xs text-slate-400">Monitor active bookings, system revenue, and tenant shortcuts.</p>
                </div>
                <button onclick="switchTab('section-users')" class="bg-rose-600 hover:bg-rose-500 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-lg shadow-rose-600/30 transition flex items-center space-x-2">
                    <i class="fa-solid fa-hotel"></i>
                    <span>Manage Tenants ({{ $tenants->count() }})</span>
                </button>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl">
                    <div class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-2">Total Tenants</div>
                    <div class="text-3xl font-black text-rose-400">{{ $tenants->count() }}</div>
                </div>
                <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl">
                    <div class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-2">Published Articles</div>
                    <div class="text-3xl font-black text-indigo-400">{{ $articles->count() }}</div>
                </div>
                <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl">
                    <div class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-2">Categories</div>
                    <div class="text-3xl font-black text-amber-400">{{ $categories->count() }}</div>
                </div>
                <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl">
                    <div class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-2">Pages</div>
                    <div class="text-3xl font-black text-emerald-400">{{ $pages->count() }}</div>
                </div>
            </div>
        </div>

        <!-- ================= 2. USERS/TENANTS ================= -->
        <div id="section-users" class="admin-section hidden space-y-6">
            <div class="bg-slate-900 border border-slate-800 p-6 md:p-8 rounded-2xl">
                <h2 class="text-xl font-bold mb-6">Registered Users & Tenants</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-300">
                        <thead class="bg-slate-950 text-xs uppercase text-slate-400 border-b border-slate-800">
                            <tr><th class="p-4">Subdomain / ID</th><th class="p-4">Hotel Name</th><th class="p-4">Email</th><th class="p-4">Status</th><th class="p-4">Actions</th></tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                            @forelse($tenants as $tenant)
                                <tr>
                                    <td class="p-4 font-mono font-bold text-white text-xs">{{ $tenant->id }}.hotel.local</td>
                                    <td class="p-4 font-bold text-indigo-400">{{ $tenant->hotel_name }}</td>
                                    <td class="p-4 text-slate-400">{{ $tenant->email }}</td>
                                    <td class="p-4"><span class="bg-emerald-500/10 text-emerald-400 text-xs px-2.5 py-1 rounded-full font-semibold">Trial Active</span></td>
                                    <td class="p-4 space-x-2 flex items-center">
                                        <a href="/hotel/{{ $tenant->id }}" target="_blank" class="bg-indigo-600/20 hover:bg-indigo-600/30 text-indigo-400 border border-indigo-500/30 px-3 py-1.5 rounded-lg text-xs font-semibold">Dashboard</a>
                                        <form action="/admin/tenants/{{ $tenant->id }}" method="POST" onsubmit="return confirm('Delete this tenant permanently?');" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 border border-rose-500/30 px-3 py-1.5 rounded-lg text-xs font-semibold">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="p-6 text-center text-slate-500">No registered tenants found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ================= 3. BLOG & ARTICLES ================= -->
        <div id="section-blog" class="admin-section hidden space-y-6">
            <div class="bg-slate-900 border border-slate-800 p-6 md:p-8 rounded-2xl space-y-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h2 class="text-xl font-bold">Blog Management System</h2>
                        <p class="text-slate-400 text-sm">Categories and articles are now saved to the database and shown live on the site.</p>
                    </div>
                    <div class="flex space-x-2 bg-slate-950 p-1.5 rounded-xl border border-slate-800">
                        <button onclick="switchBlogSubTab('blog-categories-pane')" class="px-4 py-2 rounded-lg text-xs font-semibold bg-indigo-600 text-white transition">Categories</button>
                        <button onclick="switchBlogSubTab('blog-articles-pane')" class="px-4 py-2 rounded-lg text-xs font-semibold text-slate-400 hover:text-white transition">Articles</button>
                    </div>
                </div>

                <!-- Categories -->
                <div id="blog-categories-pane" class="blog-sub-section space-y-6">
                    <form action="/admin/blog/categories" method="POST" class="bg-slate-950 p-6 rounded-2xl border border-slate-800 space-y-4 max-w-xl">
                        @csrf
                        <h3 class="font-bold text-sm text-indigo-400"><i class="fa-solid fa-folder-plus mr-2"></i> Add New Category</h3>
                        <input type="text" name="name" required placeholder="e.g. Hotel Management" class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-indigo-500">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white font-semibold px-6 py-2.5 rounded-xl text-xs transition">Save Category</button>
                    </form>

                    <div class="bg-slate-950 rounded-2xl border border-slate-800 overflow-hidden">
                        <table class="w-full text-left text-sm text-slate-300">
                            <thead class="bg-slate-900 text-xs uppercase text-slate-400"><tr><th class="p-4">Name</th><th class="p-4">Articles</th><th class="p-4">Actions</th></tr></thead>
                            <tbody class="divide-y divide-slate-800">
                                @forelse($categories as $cat)
                                <tr>
                                    <td class="p-4">
                                        <form action="/admin/blog/categories/{{ $cat->id }}" method="POST" class="flex items-center gap-2">
                                            @csrf @method('PUT')
                                            <input type="text" name="name" value="{{ $cat->name }}" class="bg-slate-900 border border-slate-800 rounded-lg px-3 py-1.5 text-xs text-white">
                                            <button class="text-indigo-400 text-xs font-semibold hover:underline">Save</button>
                                        </form>
                                    </td>
                                    <td class="p-4">{{ $cat->articles_count }}</td>
                                    <td class="p-4">
                                        <form action="/admin/blog/categories/{{ $cat->id }}" method="POST" onsubmit="return confirm('Delete category?');">
                                            @csrf @method('DELETE')
                                            <button class="bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 border border-rose-500/30 px-3 py-1.5 rounded-lg text-xs font-semibold">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="3" class="p-6 text-center text-slate-500">No categories yet.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Articles -->
                <div id="blog-articles-pane" class="blog-sub-section hidden space-y-6">
                    <form action="/admin/blog/articles" method="POST" enctype="multipart/form-data" class="bg-slate-950 p-6 rounded-2xl border border-slate-800 space-y-6">
                        @csrf
                        <h3 class="font-bold text-sm text-emerald-400"><i class="fa-solid fa-pen-nib mr-2"></i> Create Professional Article</h3>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-400 mb-1">Article Title</label>
                                <input type="text" name="title" required placeholder="e.g. Scaling Hotel Bookings" class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-emerald-500">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-400 mb-1">Select Category</label>
                                <select name="category_id" class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-emerald-500">
                                    <option value="">-- None --</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1">Short Excerpt</label>
                            <input type="text" name="excerpt" placeholder="One-line summary shown in listings" class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-emerald-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1">Featured Image (Upload)</label>
                            <input type="file" name="image" accept="image/*" class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-emerald-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1">Article Content (Rich Editor)</label>
                            <textarea class="rich-editor" name="content"></textarea>
                        </div>
                        <div class="grid md:grid-cols-2 gap-4 pt-4 border-t border-slate-800">
                            <div>
                                <label class="block text-xs font-semibold text-slate-400 mb-1">SEO Meta Keywords</label>
                                <input type="text" name="meta_keywords" placeholder="hotel booking, saas, management" class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-emerald-500">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-400 mb-1">SEO Meta Description</label>
                                <input type="text" name="meta_description" placeholder="Brief summary for search engine results..." class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-emerald-500">
                            </div>
                        </div>
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-500 text-white font-semibold px-6 py-3 rounded-xl text-sm transition">Publish Article</button>
                    </form>

                    <div class="bg-slate-950 rounded-2xl border border-slate-800 overflow-x-auto">
                        <table class="w-full text-left text-sm text-slate-300">
                            <thead class="bg-slate-900 text-xs uppercase text-slate-400"><tr><th class="p-4">Title</th><th class="p-4">Category</th><th class="p-4">Published</th><th class="p-4">Actions</th></tr></thead>
                            <tbody class="divide-y divide-slate-800">
                                @forelse($articles as $article)
                                <tr>
                                    <td class="p-4 font-semibold text-white">{{ $article->title }}</td>
                                    <td class="p-4">{{ $article->category->name ?? '—' }}</td>
                                    <td class="p-4 text-xs text-slate-400">{{ optional($article->published_at)->format('Y-m-d') }}</td>
                                    <td class="p-4 space-x-2 flex items-center">
                                        <a href="/blog/{{ $article->slug }}" target="_blank" class="text-indigo-400 text-xs font-semibold hover:underline">View</a>
                                        <a href="/admin/blog/articles/{{ $article->id }}/edit" class="text-amber-400 text-xs font-semibold hover:underline">Edit</a>
                                        <form action="/admin/blog/articles/{{ $article->id }}" method="POST" onsubmit="return confirm('Delete article?');" class="inline">
                                            @csrf @method('DELETE')
                                            <button class="bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 border border-rose-500/30 px-3 py-1.5 rounded-lg text-xs font-semibold">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="p-6 text-center text-slate-500">No articles yet.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= 4. PAGES & MENU ================= -->
        <div id="section-pages" class="admin-section hidden space-y-6">
            <div class="bg-slate-900 border border-slate-800 p-6 md:p-8 rounded-2xl space-y-8">
                <div>
                    <h2 class="text-xl font-bold">Pages & Site Menu</h2>
                    <p class="text-slate-400 text-sm">Pages you add or edit here are automatically linkable from the header menu and footer.</p>
                </div>

                <!-- Add Page -->
                <form action="/admin/pages" method="POST" class="bg-slate-950 p-6 rounded-2xl border border-slate-800 space-y-6">
                    @csrf
                    <h3 class="font-bold text-sm text-indigo-400"><i class="fa-solid fa-file-circle-plus mr-2"></i> Add New Page</h3>
                    <input type="text" name="title" required placeholder="Page Title" class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-indigo-500">
                    <textarea class="rich-editor" name="content"></textarea>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white font-semibold px-6 py-2.5 rounded-xl text-xs transition">Save Page</button>
                </form>

                <!-- Pages list -->
                <div class="bg-slate-950 rounded-2xl border border-slate-800 overflow-hidden">
                    <table class="w-full text-left text-sm text-slate-300">
                        <thead class="bg-slate-900 text-xs uppercase text-slate-400"><tr><th class="p-4">Title</th><th class="p-4">URL</th><th class="p-4">Actions</th></tr></thead>
                        <tbody class="divide-y divide-slate-800">
                            @forelse($pages as $page)
                            <tr>
                                <td class="p-4 font-semibold text-white">{{ $page->title }} @if($page->is_default)<span class="text-xs text-slate-500">(default)</span>@endif</td>
                                <td class="p-4 text-xs text-slate-400 font-mono">/page/{{ $page->slug }}</td>
                                <td class="p-4 space-x-2 flex items-center">
                                    <a href="/page/{{ $page->slug }}" target="_blank" class="text-indigo-400 text-xs font-semibold hover:underline">View</a>
                                    <a href="/admin/pages/{{ $page->id }}/edit" class="text-amber-400 text-xs font-semibold hover:underline">Edit</a>
                                    @unless($page->is_default)
                                    <form action="/admin/pages/{{ $page->id }}" method="POST" onsubmit="return confirm('Delete page?');" class="inline">
                                        @csrf @method('DELETE')
                                        <button class="bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 border border-rose-500/30 px-3 py-1.5 rounded-lg text-xs font-semibold">Delete</button>
                                    </form>
                                    @endunless
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="p-6 text-center text-slate-500">No pages yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Header menu -->
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="bg-slate-950 p-6 rounded-2xl border border-slate-800 space-y-4">
                        <h3 class="font-bold text-sm text-emerald-400"><i class="fa-solid fa-bars mr-2"></i> Header Menu</h3>
                        <form action="/admin/menu" method="POST" class="space-y-3">
                            @csrf
                            <input type="hidden" name="location" value="header">
                            <input type="text" name="label" required placeholder="Label (e.g. Pricing)" class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-2.5 text-white text-sm">
                            <select id="header-link-type" name="link_type" onchange="toggleLinkType('header')" class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-2.5 text-white text-sm">
                                <option value="url">Custom URL</option>
                                <option value="page">Existing Page</option>
                            </select>
                            <div id="header-url-field">
                                <input type="text" name="url" placeholder="/blog or https://..." class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-2.5 text-white text-sm">
                            </div>
                            <div id="header-page-field" class="hidden">
                                <select name="page_id" class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-2.5 text-white text-sm">
                                    @foreach($pages as $page)<option value="{{ $page->id }}">{{ $page->title }}</option>@endforeach
                                </select>
                            </div>
                            <input type="number" name="order" placeholder="Order (0,1,2...)" class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-2.5 text-white text-sm">
                            <button class="bg-emerald-600 hover:bg-emerald-500 text-white font-semibold px-5 py-2 rounded-xl text-xs">Add to Header</button>
                        </form>
                        <div class="space-y-2 pt-2 border-t border-slate-800">
                            @foreach($headerMenu as $item)
                            <div class="flex justify-between items-center bg-slate-900 px-4 py-2 rounded-xl text-xs">
                                <span>{{ $item->label }} <span class="text-slate-500">→ {{ $item->resolved_url }}</span></span>
                                <form action="/admin/menu/{{ $item->id }}" method="POST" onsubmit="return confirm('Remove?');">
                                    @csrf @method('DELETE')
                                    <button class="text-rose-400 font-semibold">Remove</button>
                                </form>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Footer menu -->
                    <div class="bg-slate-950 p-6 rounded-2xl border border-slate-800 space-y-4">
                        <h3 class="font-bold text-sm text-indigo-400"><i class="fa-solid fa-shoe-prints mr-2"></i> Footer Links</h3>
                        <form action="/admin/menu" method="POST" class="space-y-3">
                            @csrf
                            <input type="hidden" name="location" value="footer">
                            <input type="text" name="label" required placeholder="Label (e.g. Privacy Policy)" class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-2.5 text-white text-sm">
                            <select id="footer-link-type" name="link_type" onchange="toggleLinkType('footer')" class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-2.5 text-white text-sm">
                                <option value="page">Existing Page</option>
                                <option value="url">Custom URL</option>
                            </select>
                            <div id="footer-url-field" class="hidden">
                                <input type="text" name="url" placeholder="/blog or https://..." class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-2.5 text-white text-sm">
                            </div>
                            <div id="footer-page-field">
                                <select name="page_id" class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-2.5 text-white text-sm">
                                    @foreach($pages as $page)<option value="{{ $page->id }}">{{ $page->title }}</option>@endforeach
                                </select>
                            </div>
                            <input type="number" name="order" placeholder="Order (0,1,2...)" class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-2.5 text-white text-sm">
                            <button class="bg-indigo-600 hover:bg-indigo-500 text-white font-semibold px-5 py-2 rounded-xl text-xs">Add to Footer</button>
                        </form>
                        <div class="space-y-2 pt-2 border-t border-slate-800">
                            @foreach($footerMenu as $item)
                            <div class="flex justify-between items-center bg-slate-900 px-4 py-2 rounded-xl text-xs">
                                <span>{{ $item->label }} <span class="text-slate-500">→ {{ $item->resolved_url }}</span></span>
                                <form action="/admin/menu/{{ $item->id }}" method="POST" onsubmit="return confirm('Remove?');">
                                    @csrf @method('DELETE')
                                    <button class="text-rose-400 font-semibold">Remove</button>
                                </form>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Footer copyright -->
                <form action="/admin/footer" method="POST" class="bg-slate-950 p-6 rounded-2xl border border-slate-800 space-y-4 max-w-xl">
                    @csrf
                    <h3 class="font-bold text-sm text-emerald-400"><i class="fa-solid fa-copyright mr-2"></i> Footer Copyright Text</h3>
                    <input type="text" name="footer_copyright" value="{{ $footerCopyright }}" class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm">
                    <button class="bg-emerald-600 hover:bg-emerald-500 text-white font-semibold px-6 py-2.5 rounded-xl text-xs">Save</button>
                </form>
            </div>
        </div>

        <!-- ================= 5. DOMAINS (unchanged) ================= -->
        <div id="section-domains" class="admin-section hidden space-y-6">
            <div class="bg-slate-900 border border-slate-800 p-6 md:p-8 rounded-2xl space-y-6">
                <h2 class="text-xl font-bold">Custom Domains & Subdomains</h2>
                <div class="bg-slate-950 p-6 rounded-2xl border border-slate-800 space-y-4">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-slate-900 p-4 rounded-xl border border-slate-800 gap-4">
                        <div>
                            <p class="font-semibold text-white text-sm">www.grandplazasuites.com</p>
                            <p class="text-xs text-slate-400">Tenant ID: <span class="text-indigo-400 font-mono">grand-plaza</span></p>
                        </div>
                        <div class="space-x-2">
                            <button onclick="alert('Domain approved and SSL issued!')" class="bg-emerald-600 hover:bg-emerald-500 text-white px-4 py-2 rounded-xl text-xs font-semibold">Approve & Verify</button>
                            <button onclick="alert('Domain request rejected')" class="bg-rose-600 hover:bg-rose-500 text-white px-4 py-2 rounded-xl text-xs font-semibold">Reject</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= 6. SETTINGS & GATEWAYS (unchanged) ================= -->
        <div id="section-settings" class="admin-section hidden space-y-6">
            <div class="bg-slate-900 border border-slate-800 p-6 md:p-8 rounded-2xl space-y-6">
                <h2 class="text-xl font-bold">Payment Gateways & Settings</h2>
                <form action="/admin/settings/payment" method="POST" class="space-y-6">
                    @csrf
                    <div class="bg-slate-950 p-6 rounded-2xl border border-slate-800 space-y-4">
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-400 mb-1">Stripe Secret Key</label>
                                <input type="password" value="sk_live_51M..." class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-400 mb-1">PayPal Client ID</label>
                                <input type="text" value="AbC_Xyz987LiveClient" class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="bg-rose-600 hover:bg-rose-500 text-white font-semibold px-6 py-3 rounded-xl text-sm transition">Save Gateway Settings</button>
                </form>
            </div>
        </div>

    </main>
</body>
</html>
