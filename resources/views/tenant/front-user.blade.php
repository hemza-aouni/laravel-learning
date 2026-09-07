<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tenant->hotel_name }} | Welcome</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-950 text-slate-100 font-sans antialiased">

    <!-- Header Navbar -->
    <header class="max-w-7xl mx-auto px-6 py-6 flex justify-between items-center border-b border-slate-900">
        <div class="flex items-center space-x-3">
            <div class="bg-indigo-600 p-2.5 rounded-xl text-white">
                <i class="fa-solid fa-hotel text-xl"></i>
            </div>
            <span class="font-black text-xl tracking-wider">{{ $tenant->hotel_name }}</span>
        </div>
        <div class="space-x-4">
            <a href="#rooms" class="text-sm font-semibold text-slate-300 hover:text-white">Rooms</a>
            <a href="#booking" class="bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition shadow-lg shadow-indigo-600/30">Book Now</a>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="max-w-5xl mx-auto px-6 py-20 text-center">
        <span class="bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-widest mb-6 inline-block">
            Welcome to Luxury & Comfort
        </span>
        <h1 class="text-5xl md:text-7xl font-black tracking-tight mb-8 leading-tight">
            Experience The Best Stay At <br> <span class="bg-gradient-to-r from-indigo-400 to-violet-400 bg-clip-text text-transparent">{{ $tenant->hotel_name }}</span>
        </h1>
        <p class="text-slate-400 text-lg max-w-2xl mx-auto mb-10">
            Enjoy world-class hospitality, premium suites, and unforgettable experiences tailored just for you.
        </p>
        <div class="flex justify-center">
            <a href="#rooms" class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold px-8 py-4 rounded-2xl shadow-xl shadow-indigo-600/40 transition text-base">
                Explore Rooms & Suites <i class="fa-solid fa-arrow-down ml-2"></i>
            </a>
        </div>
    </section>

    <!-- Rooms Showcase Grid -->
    <section id="rooms" class="max-w-7xl mx-auto px-6 py-16">
        <h2 class="text-3xl font-black mb-10 text-center">Our Featured Suites</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-slate-900 border border-slate-800 rounded-3xl overflow-hidden">
                <div class="bg-slate-800 h-48 flex items-center justify-center text-slate-500"><i class="fa-solid fa-bed text-4xl"></i></div>
                <div class="p-6">
                    <h3 class="font-bold text-xl mb-2">Deluxe Ocean Suite</h3>
                    <p class="text-slate-400 text-sm mb-4">King bed, ocean view, private balcony, and luxury amenities.</p>
                    <div class="flex justify-between items-center">
                        <span class="text-indigo-400 font-black text-xl">$180 <span class="text-xs text-slate-500 font-normal">/ night</span></span>
                        <button onclick="alert('Booking feature selected!')" class="bg-slate-800 hover:bg-slate-700 text-white px-4 py-2 rounded-xl text-sm font-semibold">Book Suite</button>
                    </div>
                </div>
            </div>
            <div class="bg-slate-900 border border-slate-800 rounded-3xl overflow-hidden">
                <div class="bg-slate-800 h-48 flex items-center justify-center text-slate-500"><i class="fa-solid fa-bed text-4xl"></i></div>
                <div class="p-6">
                    <h3 class="font-bold text-xl mb-2">Executive Royal Room</h3>
                    <p class="text-slate-400 text-sm mb-4">Spacious executive room with lounge access and workspace.</p>
                    <div class="flex justify-between items-center">
                        <span class="text-indigo-400 font-black text-xl">$120 <span class="text-xs text-slate-500 font-normal">/ night</span></span>
                        <button onclick="alert('Booking feature selected!')" class="bg-slate-800 hover:bg-slate-700 text-white px-4 py-2 rounded-xl text-sm font-semibold">Book Suite</button>
                    </div>
                </div>
            </div>
            <div class="bg-slate-900 border border-slate-800 rounded-3xl overflow-hidden">
                <div class="bg-slate-800 h-48 flex items-center justify-center text-slate-500"><i class="fa-solid fa-bed text-4xl"></i></div>
                <div class="p-6">
                    <h3 class="font-bold text-xl mb-2">Standard Twin Room</h3>
                    <p class="text-slate-400 text-sm mb-4">Cozy and comfortable twin beds designed for optimal relaxation.</p>
                    <div class="flex justify-between items-center">
                        <span class="text-indigo-400 font-black text-xl">$85 <span class="text-xs text-slate-500 font-normal">/ night</span></span>
                        <button onclick="alert('Booking feature selected!')" class="bg-slate-800 hover:bg-slate-700 text-white px-4 py-2 rounded-xl text-sm font-semibold">Book Suite</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>
</html>
