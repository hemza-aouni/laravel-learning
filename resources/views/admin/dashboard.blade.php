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
            const target = document.getElementById(tabId);
            if (target) {
                target.classList.remove('hidden');
                history.replaceState(null, null, '#' + tabId);
            }
            document.getElementById('mobile-sidebar').classList.add('hidden');
        }
        function switchBlogSubTab(subTabId) {
            document.querySelectorAll('.blog-sub-section').forEach(el => el.classList.add('hidden'));
            const target = document.getElementById(subTabId);
            if (target) target.classList.remove('hidden');
        }
        function switchAppearanceSub(subId) {
            document.querySelectorAll('.appearance-sub').forEach(el => el.classList.add('hidden'));
            const target = document.getElementById(subId);
            if (target) target.classList.remove('hidden');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const hash = window.location.hash.replace('#', '');
            if (hash && document.getElementById(hash)) {
                switchTab(hash);
            }
        });
    </script>
</head>
<body class="bg-slate-950 text-slate-100 font-sans antialiased min-h-screen flex flex-col">

    <!-- Top Navbar -->
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
            <button onclick="switchTab('section-users')" class="px-3.5 py-2 rounded-xl hover:bg-slate-800 text-slate-300 transition">Tenants</button>
            <button onclick="switchTab('section-blog')" class="px-3.5 py-2 rounded-xl hover:bg-slate-800 text-slate-300 transition">Blog Management</button>
            <button onclick="switchTab('section-appearance')" class="px-3.5 py-2 rounded-xl hover:bg-slate-800 text-slate-300 transition">Appearance</button>
            <button onclick="switchTab('section-pages')" class="px-3.5 py-2 rounded-xl hover:bg-slate-800 text-slate-300 transition">Pages & Footer</button>
            <button onclick="switchTab('section-domains')" class="px-3.5 py-2 rounded-xl hover:bg-slate-800 text-slate-300 transition">Domains</button>
            <button onclick="switchTab('section-packages')" class="px-3.5 py-2 rounded-xl hover:bg-slate-800 text-slate-300 transition">Packages</button>
            <button onclick="switchTab('section-payments')" class="px-3.5 py-2 rounded-xl hover:bg-slate-800 text-slate-300 transition">Payments</button>
            <button onclick="switchTab('section-settings')" class="px-3.5 py-2 rounded-xl hover:bg-slate-800 text-slate-300 transition">Settings</button>
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

    <!-- Mobile Sidebar -->
    <div id="mobile-sidebar" class="hidden lg:hidden fixed inset-0 z-40 bg-slate-950/80 backdrop-blur-md pt-20 px-6">
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-4 shadow-2xl">
            <div class="flex justify-between items-center pb-4 border-b border-slate-800">
                <span class="font-bold text-sm text-slate-400">Navigation Menu</span>
                <button onclick="toggleMobileMenu()" class="text-slate-400 hover:text-white"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>
            <div class="flex flex-col space-y-2 text-sm font-semibold">
                <button onclick="switchTab('section-dashboard')" class="text-left px-4 py-3 rounded-xl hover:bg-slate-800">Dashboard</button>
                <button onclick="switchTab('section-users')" class="text-left px-4 py-3 rounded-xl hover:bg-slate-800">Tenants</button>
                <button onclick="switchTab('section-blog')" class="text-left px-4 py-3 rounded-xl hover:bg-slate-800">Blog Management</button>
                <button onclick="switchTab('section-appearance')" class="text-left px-4 py-3 rounded-xl hover:bg-slate-800">Appearance</button>
                <button onclick="switchTab('section-pages')" class="text-left px-4 py-3 rounded-xl hover:bg-slate-800">Pages & Footer</button>
                <button onclick="switchTab('section-domains')" class="text-left px-4 py-3 rounded-xl hover:bg-slate-800">Domains</button>
                <button onclick="switchTab('section-settings')" class="text-left px-4 py-3 rounded-xl hover:bg-slate-800">Gateways</button>
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

        <!-- ================= 1. DASHBOARD ================= -->
        <div id="section-dashboard" class="admin-section space-y-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-slate-900 border border-slate-800 p-6 rounded-2xl gap-4">
                <div>
                    <h1 class="text-2xl font-black">Admin Overview Dashboard</h1>
                    <p class="text-xs text-slate-400">Monitor active bookings, system revenue, and tenant shortcuts.</p>
                </div>
                <button onclick="switchTab('section-users')" class="bg-rose-600 hover:bg-rose-500 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-lg shadow-rose-600/30 transition flex items-center space-x-2">
                    <i class="fa-solid fa-hotel"></i>
                    <span>Manage Tenants ({{ $tenants->count() ?? 0 }})</span>
                </button>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl">
                    <div class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-2">Total Tenants</div>
                    <div class="text-3xl font-black text-rose-400">{{ $tenants->count() ?? 0 }}</div>
                </div>
                <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl">
                    <div class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-2">Total Global Bookings</div>
                    <div class="text-3xl font-black text-indigo-400">142</div>
                </div>
                <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl">
                    <div class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-2">Pending Domains</div>
                    <div class="text-3xl font-black text-amber-400">3</div>
                </div>
                <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl">
                    <div class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-2">Platform Revenue</div>
                    <div class="text-3xl font-black text-emerald-400">$8,450</div>
                </div>
            </div>
        </div>

        <!-- ================= 2. TENANTS ================= -->
        <div id="section-users" class="admin-section hidden space-y-6">
            <div class="bg-slate-900 border border-slate-800 p-6 md:p-8 rounded-2xl">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-xl font-bold">Registered Users & Tenants</h2>
                        <p class="text-slate-400 text-sm">Full information about subdomains, emails, and hotel names.</p>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-300">
                        <thead class="bg-slate-950 text-xs uppercase text-slate-400 border-b border-slate-800">
                            <tr>
                                <th class="p-4">Subdomain / ID</th>
                                <th class="p-4">Hotel Name</th>
                                <th class="p-4">Email</th>
                                <th class="p-4">Status</th>
                                <th class="p-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                            @forelse($tenants ?? [] as $tenant)
                                <tr>
                                    <td class="p-4 font-mono font-bold text-white text-xs">{{ $tenant->id }}.hotel.local</td>
                                    <td class="p-4 font-bold text-indigo-400">{{ $tenant->hotel_name }}</td>
                                    <td class="p-4 text-slate-400">{{ $tenant->email }}</td>
                                    <td class="p-4"><span class="bg-emerald-500/10 text-emerald-400 text-xs px-2.5 py-1 rounded-full font-semibold">Trial Active</span></td>
                                    <td class="p-4 space-x-2 flex items-center">
                                        <a href="/hotel/{{ $tenant->id }}" target="_blank" class="bg-indigo-600/20 hover:bg-indigo-600/30 text-indigo-400 border border-indigo-500/30 px-3 py-1.5 rounded-lg text-xs font-semibold">Dashboard</a>
                                        <form action="/admin/tenants/{{ $tenant->id }}" method="POST" onsubmit="return confirm('Delete this tenant permanently?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 border border-rose-500/30 px-3 py-1.5 rounded-lg text-xs font-semibold">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-6 text-center text-slate-500">No registered tenants found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ================= 3. BLOG MANAGEMENT ================= -->
        <div id="section-blog" class="admin-section hidden space-y-6">
            <div class="bg-slate-900 border border-slate-800 p-6 md:p-8 rounded-2xl space-y-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h2 class="text-xl font-bold">Blog Management</h2>
                        <p class="text-slate-400 text-sm">Manage categories and articles separately. Edit or delete anytime.</p>
                    </div>
                    <div class="flex space-x-2 bg-slate-950 p-1.5 rounded-xl border border-slate-800">
                        <button onclick="switchBlogSubTab('blog-categories-pane')" class="px-4 py-2 rounded-lg text-xs font-semibold bg-indigo-600 text-white transition">Categories</button>
                        <button onclick="switchBlogSubTab('blog-articles-pane')" class="px-4 py-2 rounded-lg text-xs font-semibold text-slate-400 hover:text-white transition">Articles</button>
                    </div>
                </div>

                <!-- Categories Pane -->
                <div id="blog-categories-pane" class="blog-sub-section space-y-6">
                    <form action="/admin/blog/categories" method="POST" class="bg-slate-950 p-6 rounded-2xl border border-slate-800 space-y-4 max-w-xl">
                        @csrf
                        <h3 class="font-bold text-sm text-indigo-400"><i class="fa-solid fa-folder-plus mr-2"></i> Add New Category</h3>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1">Category Name</label>
                            <input type="text" name="name" required placeholder="e.g. Hotel Management" class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-indigo-500">
                        </div>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white font-semibold px-6 py-2.5 rounded-xl text-xs transition">Save Category</button>
                    </form>

                    <!-- List of Categories (for edit/delete) -->
                    <div class="bg-slate-950 p-6 rounded-2xl border border-slate-800">
                        <h3 class="font-bold text-sm text-slate-300 mb-4">Existing Categories</h3>
                        <div class="space-y-3">
                            @forelse($categories ?? [] as $cat)
                                <div class="flex items-center justify-between bg-slate-900 p-4 rounded-xl border border-slate-800">
                                    <span class="font-semibold text-white">{{ $cat->name }}</span>
                                    <div class="flex space-x-2">
                                        <form action="/admin/blog/categories/{{ $cat->id }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="text" name="name" value="{{ $cat->name }}" class="bg-slate-800 border border-slate-700 rounded-lg px-3 py-1.5 text-xs text-white mr-2">
                                            <button type="submit" class="text-indigo-400 hover:text-indigo-300 text-xs font-semibold">Update</button>
                                        </form>
                                        <form action="/admin/blog/categories/{{ $cat->id }}" method="POST" onsubmit="return confirm('Delete this category?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-400 hover:text-rose-300 text-xs font-semibold">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <p class="text-slate-500 text-sm">No categories yet. Add one above.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Articles Pane -->
                <div id="blog-articles-pane" class="blog-sub-section hidden space-y-6">
                    <form action="/admin/blog/articles" method="POST" enctype="multipart/form-data" class="bg-slate-950 p-6 rounded-2xl border border-slate-800 space-y-6">
                        @csrf
                        <h3 class="font-bold text-sm text-emerald-400"><i class="fa-solid fa-pen-nib mr-2"></i> Create New Article</h3>
                        
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-400 mb-1">Article Title</label>
                                <input type="text" name="title" required placeholder="e.g. Scaling Hotel Bookings" class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-emerald-500">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-400 mb-1">Select Category</label>
                                <select name="category_id" class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-emerald-500">
                                    <option value="">-- Select --</option>
                                    @foreach($categories ?? [] as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1">Featured Image (Upload)</label>
                            <input type="file" name="image" accept="image/*" class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-emerald-500">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1">Article Content</label>
                            <textarea class="rich-editor" name="content"></textarea>
                        </div>

                        <div class="grid md:grid-cols-2 gap-4 pt-4 border-t border-slate-800">
                            <div>
                                <label class="block text-xs font-semibold text-slate-400 mb-1">SEO Meta Keywords</label>
                                <input type="text" name="meta_keywords" placeholder="hotel booking, saas..." class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-emerald-500">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-400 mb-1">SEO Meta Description</label>
                                <input type="text" name="meta_description" placeholder="Brief summary..." class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-emerald-500">
                            </div>
                        </div>

                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-500 text-white font-semibold px-6 py-3 rounded-xl text-sm transition">Publish Article</button>
                    </form>

                    <!-- List of Articles -->
                    <div class="bg-slate-950 p-6 rounded-2xl border border-slate-800">
                        <h3 class="font-bold text-sm text-slate-300 mb-4">Published Articles</h3>
                        <div class="space-y-3">
                            @forelse($articles ?? [] as $article)
                                <div class="flex items-center justify-between bg-slate-900 p-4 rounded-xl border border-slate-800">
                                    <div>
                                        <span class="font-semibold text-white">{{ $article->title }}</span>
                                        <span class="text-xs text-slate-500 ml-2">{{ optional($article->published_at)->format('Y-m-d') }}</span>
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="/blog/{{ $article->slug }}" target="_blank" class="text-indigo-400 hover:text-indigo-300 text-xs font-semibold">View</a>
                                        <form action="/admin/blog/articles/{{ $article->id }}" method="POST" onsubmit="return confirm('Delete this article?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-400 hover:text-rose-300 text-xs font-semibold">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <p class="text-slate-500 text-sm">No articles published yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= 4. APPEARANCE ================= -->
        <div id="section-appearance" class="admin-section hidden space-y-6">
            <div class="bg-slate-900 border border-slate-800 p-6 md:p-8 rounded-2xl space-y-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h2 class="text-xl font-bold">Appearance Settings</h2>
                        <p class="text-slate-400 text-sm">Customize Hero, CTA, Video and Testimonials of the public homepage.</p>
                    </div>
                    <div class="flex space-x-2 bg-slate-950 p-1.5 rounded-xl border border-slate-800 overflow-x-auto">
                        <button onclick="switchAppearanceSub('app-hero')" class="px-4 py-2 rounded-lg text-xs font-semibold bg-indigo-600 text-white transition whitespace-nowrap">Hero Section</button>
                        <button onclick="switchAppearanceSub('app-cta')" class="px-4 py-2 rounded-lg text-xs font-semibold text-slate-400 hover:text-white transition whitespace-nowrap">Call to Action</button>
                        <button onclick="switchAppearanceSub('app-video')" class="px-4 py-2 rounded-lg text-xs font-semibold text-slate-400 hover:text-white transition whitespace-nowrap">Video</button>
                        <button onclick="switchAppearanceSub('app-testimonials')" class="px-4 py-2 rounded-lg text-xs font-semibold text-slate-400 hover:text-white transition whitespace-nowrap">Testimonials</button>
                    </div>
                </div>

                <!-- Hero Section -->
                <div id="app-hero" class="appearance-sub space-y-6">
                    <form action="/admin/appearance/hero" method="POST" enctype="multipart/form-data" class="bg-slate-950 p-6 rounded-2xl border border-slate-800 space-y-6">
                        @csrf
                        <h3 class="font-bold text-sm text-rose-400"><i class="fa-solid fa-image mr-2"></i> Hero Section</h3>

                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1">Hero Image (Upload new image)</label>
                            <input type="file" name="hero_image" accept="image/*" class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm">
                            <p class="text-xs text-slate-500 mt-1">Leave empty to keep current default image.</p>
                        </div>

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-400 mb-1">Main Title</label>
                                <input type="text" name="hero_title" value="{{ $appearance->hero_title ?? 'Launch Your Hotel in Minutes' }}" class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-rose-500">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-400 mb-1">Subtitle / Description</label>
                                <input type="text" name="hero_subtitle" value="{{ $appearance->hero_subtitle ?? 'The complete multi-tenant ecosystem for modern hotels.' }}" class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-rose-500">
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-400 mb-1">Primary Button Text</label>
                                <input type="text" name="hero_btn_text" value="{{ $appearance->hero_btn_text ?? 'Deploy Your Hotel Now' }}" class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-rose-500">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-400 mb-1">Primary Button Link</label>
                                <input type="text" name="hero_btn_link" value="{{ $appearance->hero_btn_link ?? '/deploy' }}" class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-rose-500">
                                <p class="text-xs text-slate-500 mt-1">Keep <code class="text-emerald-400">/deploy</code> for demo trial (recommended).</p>
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-400 mb-1">Secondary Button Text</label>
                                <input type="text" name="hero_btn2_text" value="{{ $appearance->hero_btn2_text ?? 'Explore Features' }}" class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-400 mb-1">Secondary Button Link</label>
                                <input type="text" name="hero_btn2_link" value="{{ $appearance->hero_btn2_link ?? '/#features' }}" class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm">
                            </div>
                        </div>

                        <button type="submit" class="bg-rose-600 hover:bg-rose-500 text-white font-semibold px-6 py-3 rounded-xl text-sm transition">Save Hero Settings</button>
                    </form>
                </div>

                <!-- Call to Action -->
                <div id="app-cta" class="appearance-sub hidden space-y-6">
                    <form action="/admin/appearance/cta" method="POST" class="bg-slate-950 p-6 rounded-2xl border border-slate-800 space-y-6">
                        @csrf
                        <h3 class="font-bold text-sm text-indigo-400"><i class="fa-solid fa-bullhorn mr-2"></i> Call to Action Section</h3>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1">CTA Title</label>
                            <input type="text" name="cta_title" value="{{ $appearance->cta_title ?? 'Ready to Transform Your Hotel?' }}" class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1">CTA Description</label>
                            <textarea name="cta_description" rows="2" class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm">{{ $appearance->cta_description ?? 'Join hundreds of hotels already using our platform.' }}</textarea>
                        </div>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-400 mb-1">Button Text</label>
                                <input type="text" name="cta_btn_text" value="{{ $appearance->cta_btn_text ?? 'Start Your Free Trial' }}" class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-400 mb-1">Button Link</label>
                                <input type="text" name="cta_btn_link" value="{{ $appearance->cta_btn_link ?? '/deploy' }}" class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm">
                            </div>
                        </div>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white font-semibold px-6 py-3 rounded-xl text-sm transition">Save CTA Settings</button>
                    </form>
                </div>

                <!-- Video -->
                <div id="app-video" class="appearance-sub hidden space-y-6">
                    <form action="/admin/appearance/video" method="POST" class="bg-slate-950 p-6 rounded-2xl border border-slate-800 space-y-6">
                        @csrf
                        <h3 class="font-bold text-sm text-emerald-400"><i class="fa-solid fa-video mr-2"></i> Video Section</h3>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1">YouTube / Vimeo Embed URL</label>
                            <input type="text" name="video_url" value="{{ $appearance->video_url ?? '' }}" placeholder="https://www.youtube.com/embed/xxxxx" class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1">Video Title</label>
                            <input type="text" name="video_title" value="{{ $appearance->video_title ?? 'See How It Works' }}" class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm">
                        </div>
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-500 text-white font-semibold px-6 py-3 rounded-xl text-sm transition">Save Video Settings</button>
                    </form>
                </div>

                <!-- Testimonials -->
                <div id="app-testimonials" class="appearance-sub hidden space-y-6">
                    <form action="/admin/appearance/testimonials" method="POST" class="bg-slate-950 p-6 rounded-2xl border border-slate-800 space-y-6">
                        @csrf
                        <h3 class="font-bold text-sm text-amber-400"><i class="fa-solid fa-quote-left mr-2"></i> Testimonials</h3>
                        <p class="text-xs text-slate-500">Add up to 3 testimonials (JSON format or simple text for now).</p>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1">Testimonial 1 (Name | Text)</label>
                            <input type="text" name="testimonial_1" value="{{ $appearance->testimonial_1 ?? 'Ahmed R. | Amazing platform, increased our bookings by 40%!' }}" class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1">Testimonial 2</label>
                            <input type="text" name="testimonial_2" value="{{ $appearance->testimonial_2 ?? 'Sara M. | Easy to use and very professional.' }}" class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1">Testimonial 3</label>
                            <input type="text" name="testimonial_3" value="{{ $appearance->testimonial_3 ?? 'Omar K. | Best decision for our hotel chain.' }}" class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm">
                        </div>
                        <button type="submit" class="bg-amber-600 hover:bg-amber-500 text-white font-semibold px-6 py-3 rounded-xl text-sm transition">Save Testimonials</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- ================= 5. PAGES & FOOTER ================= -->
        <div id="section-pages" class="admin-section hidden space-y-6">
            <div class="bg-slate-900 border border-slate-800 p-6 md:p-8 rounded-2xl space-y-8">
                <div>
                    <h2 class="text-xl font-bold">Pages & Footer Management</h2>
                    <p class="text-slate-400 text-sm">Create and edit vital pages and configure footer details.</p>
                </div>

                <form action="/admin/pages" method="POST" class="bg-slate-950 p-6 rounded-2xl border border-slate-800 space-y-6">
                    @csrf
                    <div class="flex justify-between items-center">
                        <h3 class="font-bold text-sm text-indigo-400"><i class="fa-solid fa-file-lines mr-2"></i> Page Content Editor</h3>
                        <select name="page_slug" class="bg-slate-900 border border-slate-800 rounded-xl px-3 py-2 text-white text-xs">
                            <option value="privacy-policy">Privacy Policy</option>
                            <option value="terms-of-service">Terms of Service</option>
                            <option value="about-us">About Us</option>
                            <option value="contact-us">Contact Us</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1">Page Body Content</label>
                        <textarea class="rich-editor" name="page_content"></textarea>
                    </div>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white font-semibold px-6 py-2.5 rounded-xl text-xs transition">Save Page Content</button>
                </form>

                <form action="/admin/footer" method="POST" class="bg-slate-950 p-6 rounded-2xl border border-slate-800 space-y-6">
                    @csrf
                    <h3 class="font-bold text-sm text-emerald-400"><i class="fa-solid fa-shoe-prints mr-2"></i> Footer Settings</h3>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1">Copyright Text</label>
                        <input type="text" name="copyright" value="All Rights Reserved © {{ date('Y') }}" class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm">
                    </div>
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-500 text-white font-semibold px-6 py-2.5 rounded-xl text-xs transition">Save Footer Settings</button>
                </form>
            </div>
        </div>

        <!-- ================= 6. DOMAINS ================= -->
        <div id="section-domains" class="admin-section hidden space-y-6">
            <div class="bg-slate-900 border border-slate-800 p-6 md:p-8 rounded-2xl space-y-6">
                <div>
                    <h2 class="text-xl font-bold">Custom Domains & Subdomains</h2>
                    <p class="text-slate-400 text-sm">Review incoming domain connection requests.</p>
                </div>
                <div class="bg-slate-950 p-6 rounded-2xl border border-slate-800 space-y-4">
                    <h3 class="font-bold text-sm text-indigo-400"><i class="fa-solid fa-globe mr-2"></i> Pending Custom Domain Requests</h3>
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

        <!-- ================= 7. SETTINGS ================= -->
        <div id="section-settings" class="admin-section hidden space-y-6">
            <div class="bg-slate-900 border border-slate-800 p-6 md:p-8 rounded-2xl space-y-6">
                <div>
                    <h2 class="text-xl font-bold">Payment Gateways & Settings</h2>
                    <p class="text-slate-400 text-sm">Configure online payment providers.</p>
                </div>
                <form action="/admin/settings/payment" method="POST" class="space-y-6">
                    @csrf
                    <div class="bg-slate-950 p-6 rounded-2xl border border-slate-800 space-y-4">
                        <h3 class="font-bold text-sm text-indigo-400"><i class="fa-solid fa-credit-card mr-2"></i> Online Payment Gateways</h3>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-400 mb-1">Stripe Secret Key</label>
                                <input type="password" name="stripe_key" value="sk_live_51M..." class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-400 mb-1">PayPal Client ID</label>
                                <input type="text" name="paypal_client" value="AbC_Xyz987LiveClient" class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm">
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
