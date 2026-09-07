<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tenant->hotel_name ?? 'Grand View Hotel' }} — Book Your Stay</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1e3a8a',
                        'primary-dark': '#1e40af',
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        .hero-height { height: 85vh; }
        @media (max-width: 768px) {
            .hero-height { height: 70vh; }
        }
        .room-scroll {
            scroll-snap-type: x mandatory;
            -webkit-overflow-scrolling: touch;
        }
        .room-scroll > * {
            scroll-snap-align: start;
        }
    </style>
</head>
<body class="bg-white text-slate-800 font-sans antialiased">

    <!-- ===================== HEADER ===================== -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3.5 flex items-center justify-between">
            <!-- Logo -->
            <a href="{{ url()->current() }}" class="flex items-center space-x-2">
                <div class="w-9 h-9 bg-primary rounded-lg flex items-center justify-center text-white font-black text-sm">
                    {{ strtoupper(substr($tenant->hotel_name ?? 'H', 0, 1)) }}
                </div>
                <span class="font-bold text-lg text-slate-900 tracking-tight">{{ $tenant->hotel_name ?? 'Grand View Hotel' }}</span>
            </a>

            <!-- Desktop Nav -->
            <nav class="hidden md:flex items-center space-x-8 text-sm font-medium text-slate-600">
                <a href="#home" class="hover:text-primary transition">Home</a>
                <a href="#rooms" class="hover:text-primary transition">Rooms</a>
                <a href="#about" class="hover:text-primary transition">About</a>
                <a href="#gallery" class="hover:text-primary transition">Gallery</a>
                <a href="#contact" class="hover:text-primary transition">Contact</a>
            </nav>

            <!-- Right side -->
            <div class="flex items-center space-x-3">
                <div class="hidden sm:flex items-center space-x-1 text-sm text-slate-500">
                    <i class="fa-solid fa-globe text-xs"></i>
                    <span>EN</span>
                </div>
                <a href="#search" class="bg-primary hover:bg-primary-dark text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition shadow-md shadow-primary/20">
                    Book Now
                </a>
                <!-- Mobile menu button -->
                <button onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="md:hidden p-2 text-slate-600">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden border-t border-slate-100 bg-white">
            <nav class="flex flex-col px-4 py-3 space-y-1 text-sm font-medium text-slate-600">
                <a href="#home" class="px-4 py-3 rounded-lg hover:bg-slate-50">Home</a>
                <a href="#rooms" class="px-4 py-3 rounded-lg hover:bg-slate-50">Rooms</a>
                <a href="#about" class="px-4 py-3 rounded-lg hover:bg-slate-50">About</a>
                <a href="#gallery" class="px-4 py-3 rounded-lg hover:bg-slate-50">Gallery</a>
                <a href="#contact" class="px-4 py-3 rounded-lg hover:bg-slate-50">Contact</a>
            </nav>
        </div>
    </header>

    <!-- ===================== HERO ===================== -->
    <section id="home" class="relative hero-height overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1582719508461-905c673771fd?auto=format&fit=crop&w=1920&q=80"
                 alt="Luxury Hotel"
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-slate-900/80 via-slate-900/50 to-transparent"></div>
        </div>

        <!-- Hero Content -->
        <div class="relative h-full max-w-7xl mx-auto px-4 sm:px-6 flex items-center">
            <div class="max-w-xl text-white space-y-5 md:space-y-6 text-center md:text-left mx-auto md:mx-0">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-tight tracking-tight">
                    Your Perfect Stay<br>Awaits
                </h1>
                <p class="text-lg text-white/80 leading-relaxed max-w-md mx-auto md:mx-0">
                    Comfortable rooms, amazing views, and unforgettable experiences at {{ $tenant->hotel_name ?? 'our hotel' }}.
                </p>
                <a href="#search" class="inline-flex items-center space-x-2 bg-white text-primary hover:bg-slate-100 px-7 py-3.5 rounded-xl font-bold text-sm transition shadow-xl">
                    <span>Explore Rooms</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- ===================== SEARCH BAR (Floating) ===================== -->
    <div id="search" class="relative z-20 max-w-5xl mx-auto px-4 sm:px-6 -mt-16">
        <form action="#" method="GET" class="bg-white rounded-2xl shadow-2xl border border-slate-100 p-4 sm:p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Check In -->
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider flex items-center space-x-1.5">
                        <i class="fa-regular fa-calendar text-primary"></i>
                        <span>Check In</span>
                    </label>
                    <input type="date" name="check_in" 
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition"
                           value="{{ date('Y-m-d') }}">
                </div>

                <!-- Check Out -->
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider flex items-center space-x-1.5">
                        <i class="fa-regular fa-calendar text-primary"></i>
                        <span>Check Out</span>
                    </label>
                    <input type="date" name="check_out"
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition"
                           value="{{ date('Y-m-d', strtotime('+2 days')) }}">
                </div>

                <!-- Guests -->
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider flex items-center space-x-1.5">
                        <i class="fa-regular fa-user text-primary"></i>
                        <span>Guests</span>
                    </label>
                    <select name="guests"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition">
                        <option value="1">1 Adult</option>
                        <option value="2" selected>2 Adults</option>
                        <option value="3">2 Adults + 1 Child</option>
                        <option value="4">2 Adults + 2 Children</option>
                        <option value="5">3 Adults</option>
                        <option value="6">4 Adults</option>
                    </select>
                </div>

                <!-- Search Button -->
                <div class="flex items-end">
                    <button type="submit"
                            class="w-full bg-primary hover:bg-primary-dark text-white font-bold py-3.5 rounded-xl transition shadow-lg shadow-primary/25 flex items-center justify-center space-x-2">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span>Search</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- ===================== OUR ROOMS ===================== -->
    <section id="rooms" class="max-w-7xl mx-auto px-4 sm:px-6 py-20">
        <div class="text-center mb-12">
            <h2 class="text-3xl sm:text-4xl font-black text-slate-900">Our Rooms</h2>
            <p class="text-slate-500 mt-2">Choose the perfect room for your stay</p>
        </div>

        <!-- Desktop Grid / Mobile Horizontal Scroll -->
        <div class="hidden md:grid md:grid-cols-3 gap-8">
            <!-- Room 1 -->
            <a href="#" class="group bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-xl transition duration-300">
                <div class="overflow-hidden aspect-video">
                    <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?auto=format&fit=crop&w=800&q=80"
                         alt="Standard Room"
                         class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-lg text-slate-900">Standard Room</h3>
                    <p class="text-sm text-slate-500 mt-1">Cozy and comfortable for short stays</p>
                    <div class="flex items-center justify-between mt-4">
                        <span class="text-primary font-bold text-lg">$80 <span class="text-sm font-normal text-slate-400">/ night</span></span>
                        <span class="text-xs bg-slate-100 text-slate-600 px-2.5 py-1 rounded-full">2 Guests</span>
                    </div>
                </div>
            </a>

            <!-- Room 2 -->
            <a href="#" class="group bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-xl transition duration-300">
                <div class="overflow-hidden aspect-video">
                    <img src="https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=800&q=80"
                         alt="Deluxe Room"
                         class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-lg text-slate-900">Deluxe Room</h3>
                    <p class="text-sm text-slate-500 mt-1">Spacious with city or sea view</p>
                    <div class="flex items-center justify-between mt-4">
                        <span class="text-primary font-bold text-lg">$120 <span class="text-sm font-normal text-slate-400">/ night</span></span>
                        <span class="text-xs bg-slate-100 text-slate-600 px-2.5 py-1 rounded-full">3 Guests</span>
                    </div>
                </div>
            </a>

            <!-- Room 3 -->
            <a href="#" class="group bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-xl transition duration-300">
                <div class="overflow-hidden aspect-video">
                    <img src="https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=800&q=80"
                         alt="Suite Room"
                         class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-lg text-slate-900">Suite Room</h3>
                    <p class="text-sm text-slate-500 mt-1">Luxury suite with private balcony</p>
                    <div class="flex items-center justify-between mt-4">
                        <span class="text-primary font-bold text-lg">$180 <span class="text-sm font-normal text-slate-400">/ night</span></span>
                        <span class="text-xs bg-slate-100 text-slate-600 px-2.5 py-1 rounded-full">4 Guests</span>
                    </div>
                </div>
            </a>
        </div>

        <!-- Mobile Horizontal Scroll -->
        <div class="md:hidden flex overflow-x-auto room-scroll gap-4 pb-4 -mx-4 px-4">
            <a href="#" class="flex-shrink-0 w-[85%] bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-sm">
                <div class="aspect-video overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?auto=format&fit=crop&w=800&q=80" class="w-full h-full object-cover" alt="Standard">
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-slate-900">Standard Room</h3>
                    <p class="text-primary font-bold mt-1">$80 <span class="text-sm font-normal text-slate-400">/ night</span></p>
                </div>
            </a>
            <a href="#" class="flex-shrink-0 w-[85%] bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-sm">
                <div class="aspect-video overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=800&q=80" class="w-full h-full object-cover" alt="Deluxe">
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-slate-900">Deluxe Room</h3>
                    <p class="text-primary font-bold mt-1">$120 <span class="text-sm font-normal text-slate-400">/ night</span></p>
                </div>
            </a>
            <a href="#" class="flex-shrink-0 w-[85%] bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-sm">
                <div class="aspect-video overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=800&q=80" class="w-full h-full object-cover" alt="Suite">
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-slate-900">Suite Room</h3>
                    <p class="text-primary font-bold mt-1">$180 <span class="text-sm font-normal text-slate-400">/ night</span></p>
                </div>
            </a>
        </div>
    </section>

    <!-- ===================== FEATURES ===================== -->
    <section class="bg-slate-50 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-14">
                <h2 class="text-3xl sm:text-4xl font-black text-slate-900">Why Choose Us</h2>
                <p class="text-slate-500 mt-2">Everything you need for a perfect stay</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <!-- Feature items -->
                <div class="bg-white rounded-2xl p-6 text-center shadow-sm border border-slate-100 hover:shadow-md transition">
                    <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center text-2xl mx-auto mb-4">
                        <i class="fa-solid fa-bed"></i>
                    </div>
                    <h3 class="font-bold text-sm text-slate-900">Online Booking</h3>
                    <p class="text-xs text-slate-500 mt-1">Easy & Fast Reservations</p>
                </div>

                <div class="bg-white rounded-2xl p-6 text-center shadow-sm border border-slate-100 hover:shadow-md transition">
                    <div class="w-14 h-14 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center text-2xl mx-auto mb-4">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <h3 class="font-bold text-sm text-slate-900">Real-Time Availability</h3>
                    <p class="text-xs text-slate-500 mt-1">Live room status</p>
                </div>

                <div class="bg-white rounded-2xl p-6 text-center shadow-sm border border-slate-100 hover:shadow-md transition">
                    <div class="w-14 h-14 bg-purple-100 text-purple-600 rounded-2xl flex items-center justify-center text-2xl mx-auto mb-4">
                        <i class="fa-solid fa-credit-card"></i>
                    </div>
                    <h3 class="font-bold text-sm text-slate-900">Secure Payment</h3>
                    <p class="text-xs text-slate-500 mt-1">Visa · PayPal · Apple Pay</p>
                </div>

                <div class="bg-white rounded-2xl p-6 text-center shadow-sm border border-slate-100 hover:shadow-md transition">
                    <div class="w-14 h-14 bg-orange-100 text-orange-600 rounded-2xl flex items-center justify-center text-2xl mx-auto mb-4">
                        <i class="fa-solid fa-bell"></i>
                    </div>
                    <h3 class="font-bold text-sm text-slate-900">Instant Confirmation</h3>
                    <p class="text-xs text-slate-500 mt-1">Email & SMS alerts</p>
                </div>

                <div class="bg-white rounded-2xl p-6 text-center shadow-sm border border-slate-100 hover:shadow-md transition">
                    <div class="w-14 h-14 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center text-2xl mx-auto mb-4">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>
                    <h3 class="font-bold text-sm text-slate-900">Guest Management</h3>
                    <p class="text-xs text-slate-500 mt-1">Profiles & Preferences</p>
                </div>

                <div class="bg-white rounded-2xl p-6 text-center shadow-sm border border-slate-100 hover:shadow-md transition">
                    <div class="w-14 h-14 bg-rose-100 text-rose-600 rounded-2xl flex items-center justify-center text-2xl mx-auto mb-4">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <h3 class="font-bold text-sm text-slate-900">Hotel Management</h3>
                    <p class="text-xs text-slate-500 mt-1">Bookings · Rooms · Reports</p>
                </div>

                <div class="bg-white rounded-2xl p-6 text-center shadow-sm border border-slate-100 hover:shadow-md transition">
                    <div class="w-14 h-14 bg-cyan-100 text-cyan-600 rounded-2xl flex items-center justify-center text-2xl mx-auto mb-4">
                        <i class="fa-solid fa-globe"></i>
                    </div>
                    <h3 class="font-bold text-sm text-slate-900">Multi-Language</h3>
                    <p class="text-xs text-slate-500 mt-1">Reach global guests</p>
                </div>

                <div class="bg-white rounded-2xl p-6 text-center shadow-sm border border-slate-100 hover:shadow-md transition">
                    <div class="w-14 h-14 bg-teal-100 text-teal-600 rounded-2xl flex items-center justify-center text-2xl mx-auto mb-4">
                        <i class="fa-solid fa-mobile-screen"></i>
                    </div>
                    <h3 class="font-bold text-sm text-slate-900">Responsive Design</h3>
                    <p class="text-xs text-slate-500 mt-1">Perfect on all devices</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===================== CTA ===================== -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 py-16">
        <div class="bg-primary rounded-3xl p-10 md:p-14 text-center text-white relative overflow-hidden">
            <div class="relative z-10 space-y-5">
                <h2 class="text-3xl md:text-4xl font-black">Ready for an Unforgettable Stay?</h2>
                <p class="text-white/80 max-w-lg mx-auto">Book your room now and enjoy exclusive rates at {{ $tenant->hotel_name ?? 'our hotel' }}.</p>
                <a href="#search" class="inline-flex items-center space-x-2 bg-white text-primary hover:bg-slate-100 px-8 py-4 rounded-2xl font-bold text-sm transition shadow-xl">
                    <span>Book Now</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- ===================== FOOTER ===================== -->
    <footer id="contact" class="bg-slate-900 text-slate-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-14">
            <div class="grid md:grid-cols-4 gap-10">
                <div class="space-y-4">
                    <div class="flex items-center space-x-2">
                        <div class="w-9 h-9 bg-primary rounded-lg flex items-center justify-center text-white font-black text-sm">
                            {{ strtoupper(substr($tenant->hotel_name ?? 'H', 0, 1)) }}
                        </div>
                        <span class="font-bold text-white text-lg">{{ $tenant->hotel_name ?? 'Grand View Hotel' }}</span>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Experience luxury and comfort in the heart of the city. Your perfect stay starts here.
                    </p>
                </div>

                <div>
                    <h4 class="font-bold text-white mb-4 text-sm uppercase tracking-wider">Quick Links</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#home" class="hover:text-white transition">Home</a></li>
                        <li><a href="#rooms" class="hover:text-white transition">Rooms</a></li>
                        <li><a href="#about" class="hover:text-white transition">About</a></li>
                        <li><a href="#contact" class="hover:text-white transition">Contact</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-white mb-4 text-sm uppercase tracking-wider">Contact</h4>
                    <ul class="space-y-2 text-sm text-slate-400">
                        <li class="flex items-center space-x-2"><i class="fa-solid fa-envelope text-xs"></i><span>{{ $tenant->email ?? 'info@hotel.com' }}</span></li>
                        <li class="flex items-center space-x-2"><i class="fa-solid fa-phone text-xs"></i><span>+1 (555) 123-4567</span></li>
                        <li class="flex items-center space-x-2"><i class="fa-solid fa-location-dot text-xs"></i><span>123 Ocean Drive</span></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-white mb-4 text-sm uppercase tracking-wider">Payment Methods</h4>
                    <div class="flex flex-wrap gap-2">
                        <span class="bg-slate-800 px-3 py-1.5 rounded-lg text-xs font-semibold">Visa</span>
                        <span class="bg-slate-800 px-3 py-1.5 rounded-lg text-xs font-semibold">Mastercard</span>
                        <span class="bg-slate-800 px-3 py-1.5 rounded-lg text-xs font-semibold">PayPal</span>
                        <span class="bg-slate-800 px-3 py-1.5 rounded-lg text-xs font-semibold">Apple Pay</span>
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-800 mt-10 pt-6 flex flex-col sm:flex-row justify-between items-center gap-3 text-xs text-slate-500">
                <p>© {{ date('Y') }} {{ $tenant->hotel_name ?? 'Grand View Hotel' }}. All rights reserved.</p>
                <p>Powered by SaaSPlatform</p>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        });
    </script>
</body>
</html>
