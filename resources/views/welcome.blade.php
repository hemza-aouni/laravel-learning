<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SaaS Platform & Hotel Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-950 text-slate-100 font-sans antialiased min-h-screen flex flex-col">

@include('partials.menu')

@php
    $heroTitle     = $appearance->hero_title     ?? 'Launch Your Hotel in Minutes';
    $heroSubtitle  = $appearance->hero_subtitle  ?? 'The complete multi-tenant ecosystem for modern hotels. Deploy instant booking platforms, manage reservations, and scale your hospitality business effortlessly.';
    $heroBtnText   = $appearance->hero_btn_text  ?? 'Deploy Your Hotel Now';
    $heroBtnLink   = $appearance->hero_btn_link  ?? '/deploy';
    $heroBtn2Text  = $appearance->hero_btn2_text ?? 'Explore Features';
    $heroBtn2Link  = $appearance->hero_btn2_link ?? '/#features';

    $defaultImage = 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1200&q=80';
    $heroImage = $defaultImage;

    if (!empty($appearance->hero_image)) {
        if (str_starts_with($appearance->hero_image, 'http')) {
            $heroImage = $appearance->hero_image;
        } else {
            $heroImage = asset($appearance->hero_image);
        }
    }
@endphp

<!-- Hero Section -->
<section class="relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-slate-950 via-slate-900 to-indigo-950/40"></div>
    <div class="relative max-w-7xl mx-auto px-6 py-16 md:py-24 grid lg:grid-cols-2 gap-12 items-center">
        
        <div class="space-y-8">
            <div class="inline-flex items-center space-x-2 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs font-semibold px-3 py-1.5 rounded-full">
                <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                <span>Multi-Tenant SaaS Platform</span>
            </div>
            
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-black leading-tight">
                {{ $heroTitle }}
            </h1>
            
            <p class="text-slate-400 text-lg max-w-lg leading-relaxed">
                {{ $heroSubtitle }}
            </p>

            <div class="flex flex-wrap gap-4">
                <a href="{{ $heroBtnLink }}" class="bg-rose-600 hover:bg-rose-500 text-white px-8 py-4 rounded-2xl font-bold text-sm transition shadow-xl shadow-rose-600/25 flex items-center space-x-2">
                    <i class="fa-solid fa-rocket"></i>
                    <span>{{ $heroBtnText }}</span>
                </a>
                <a href="{{ $heroBtn2Link }}" class="bg-slate-800 hover:bg-slate-700 text-white px-8 py-4 rounded-2xl font-bold text-sm transition border border-slate-700">
                    {{ $heroBtn2Text }}
                </a>
            </div>

            <div class="flex items-center space-x-6 text-sm text-slate-400 pt-2">
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-check text-emerald-400"></i>
                    <span>Free 1-day trial</span>
                </div>
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-check text-emerald-400"></i>
                    <span>No credit card</span>
                </div>
            </div>
        </div>

        <div class="relative">
            <div class="absolute -inset-4 bg-gradient-to-r from-rose-600/20 to-indigo-600/20 rounded-3xl blur-2xl"></div>
            <img src="{{ $heroImage }}" 
                 alt="Hotel Platform" 
                 class="relative rounded-3xl shadow-2xl border border-slate-800 w-full object-cover aspect-[4/3]"
                 onerror="this.onerror=null; this.src='{{ $defaultImage }}';">
        </div>
    </div>
</section>

<!-- Features -->
<section id="features" class="max-w-7xl mx-auto px-6 py-20">
    <div class="text-center mb-14">
        <h2 class="text-3xl md:text-4xl font-black mb-4">Everything You Need</h2>
        <p class="text-slate-400 max-w-2xl mx-auto">Powerful tools designed specifically for hotel owners and managers.</p>
    </div>

    <div class="grid md:grid-cols-3 gap-8">
        <div class="bg-slate-900 border border-slate-800 rounded-3xl p-8 hover:border-indigo-500/50 transition group">
            <div class="w-14 h-14 bg-indigo-500/10 text-indigo-400 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition">
                <i class="fa-solid fa-building"></i>
            </div>
            <h3 class="text-xl font-bold mb-3">Instant Deployment</h3>
            <p class="text-slate-400 text-sm leading-relaxed">Launch a fully branded hotel website with booking engine in under 60 seconds.</p>
        </div>
        <div class="bg-slate-900 border border-slate-800 rounded-3xl p-8 hover:border-rose-500/50 transition group">
            <div class="w-14 h-14 bg-rose-500/10 text-rose-400 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <h3 class="text-xl font-bold mb-3">Smart Bookings</h3>
            <p class="text-slate-400 text-sm leading-relaxed">Real-time availability, automatic confirmations, and seamless guest management.</p>
        </div>
        <div class="bg-slate-900 border border-slate-800 rounded-3xl p-8 hover:border-emerald-500/50 transition group">
            <div class="w-14 h-14 bg-emerald-500/10 text-emerald-400 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition">
                <i class="fa-solid fa-chart-line"></i>
            </div>
            <h3 class="text-xl font-bold mb-3">Growth Analytics</h3>
            <p class="text-slate-400 text-sm leading-relaxed">Track revenue, occupancy rates, and guest insights from a single dashboard.</p>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="max-w-7xl mx-auto px-6 py-10">
    <div class="bg-gradient-to-r from-rose-600 to-indigo-600 rounded-3xl p-10 md:p-14 text-center relative overflow-hidden">
        <div class="relative z-10 space-y-6">
            <h2 class="text-3xl md:text-4xl font-black">{{ $appearance->cta_title ?? 'Ready to Transform Your Hotel?' }}</h2>
            <p class="text-white/80 max-w-xl mx-auto">{{ $appearance->cta_description ?? 'Join hundreds of hotels already using our platform to increase bookings and streamline operations.' }}</p>
            <a href="{{ $appearance->cta_btn_link ?? '/deploy' }}" class="inline-flex items-center space-x-2 bg-white text-slate-900 hover:bg-slate-100 px-8 py-4 rounded-2xl font-bold text-sm transition shadow-xl">
                <span>{{ $appearance->cta_btn_text ?? 'Start Your Free Trial' }}</span>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

<!-- ===================== Latest Articles ===================== -->
<main class="max-w-7xl mx-auto px-6 py-20">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4 mb-10">
        <div>
            <h2 class="text-3xl font-black">Latest Articles & News</h2>
            <p class="text-slate-400 text-sm mt-2">Insights, guides and updates from the hospitality world</p>
        </div>
        <a href="/blog" class="text-indigo-400 hover:text-indigo-300 text-sm font-semibold">
            View All Blog →
        </a>
    </div>

    <div class="grid md:grid-cols-3 gap-6">
        @forelse($latestArticles ?? [] as $article)
            <a href="/blog/{{ $article->slug }}" class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden shadow-xl flex flex-col hover:border-indigo-500 transition group">
                @if(!empty($article->image))
                    <img src="{{ asset($article->image) }}" alt="{{ $article->title }}" class="h-48 w-full object-cover group-hover:scale-105 transition duration-500">
                @else
                    <div class="h-48 bg-slate-800 flex items-center justify-center text-slate-600">
                        <i class="fa-solid fa-image text-4xl"></i>
                    </div>
                @endif
                <div class="p-6 space-y-3 flex-1 flex flex-col justify-between">
                    <div>
                        @if($article->category ?? false)
                            <span class="bg-indigo-500/10 text-indigo-400 text-xs px-2.5 py-1 rounded-full font-semibold">{{ $article->category->name }}</span>
                        @endif
                        <h3 class="font-bold text-lg mt-2 text-white group-hover:text-indigo-300 transition">{{ $article->title }}</h3>
                        <p class="text-slate-400 text-xs mt-1">
                            {{ $article->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($article->content ?? ''), 90) }}
                        </p>
                    </div>
                    <div class="text-xs text-slate-500 pt-4 border-t border-slate-800 flex justify-between">
                        <span>{{ optional($article->published_at)->format('Y-m-d') ?? '' }}</span>
                        <span class="text-emerald-400 font-semibold">Read more</span>
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-3 text-center py-16 bg-slate-900/50 border border-slate-800 rounded-2xl">
                <div class="w-16 h-16 bg-slate-800 rounded-2xl flex items-center justify-center mx-auto mb-5">
                    <i class="fa-solid fa-newspaper text-2xl text-slate-600"></i>
                </div>
                <h3 class="font-bold text-slate-300 mb-2">No articles yet</h3>
                <p class="text-slate-500 text-sm mb-6">Publish your first article from the Super Admin panel.</p>
                <a href="/admin/dashboard#section-blog" class="inline-flex items-center space-x-2 bg-indigo-600 hover:bg-indigo-500 text-white px-5 py-2.5 rounded-xl text-xs font-semibold transition">
                    <i class="fa-solid fa-pen"></i>
                    <span>Go to Blog Management</span>
                </a>
            </div>
        @endforelse
    </div>
</main>

@include('partials.footer')

</body>
</html>
