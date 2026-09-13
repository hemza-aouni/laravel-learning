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
                    colors: { primary: '#1e3a8a', 'primary-dark': '#1e40af' },
                    fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] }
                }
            }
        }
        function openBookingModal(roomId, roomName, price) {
            document.getElementById('booking-room-id').value = roomId;
            document.getElementById('booking-room-name').textContent = roomName;
            document.getElementById('booking-room-price').textContent = '$' + price + ' / night';
            document.getElementById('booking-modal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        function closeBookingModal() {
            document.getElementById('booking-modal').classList.add('hidden');
            document.body.style.overflow = '';
        }
    </script>
    <style>
        .hero-height { height: 85vh; }
        @media (max-width: 768px) { .hero-height { height: 70vh; } }
        .room-scroll { scroll-snap-type: x mandatory; -webkit-overflow-scrolling: touch; }
        .room-scroll > * { scroll-snap-align: start; }
    </style>
</head>
<body class="bg-white text-slate-800 font-sans antialiased">
    <!-- ===================== HEADER ===================== -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3.5 flex items-center justify-between">
            <a href="{{ url()->current() }}" class="flex items-center space-x-2">
                <div class="w-9 h-9 bg-primary rounded-lg flex items-center justify-center text-white font-black text-sm">
                    {{ strtoupper(substr($tenant->hotel_name ?? 'H', 0, 1)) }}
                </div>
                <span class="font-bold text-lg text-slate-900 tracking-tight">{{ $tenant->hotel_name ?? 'Grand View Hotel' }}</span>
            </a>
            <nav class="hidden md:flex items-center space-x-8 text-sm font-medium text-slate-600">
                <a href="#home" class="hover:text-primary transition">Home</a>
                <a href="#rooms" class="hover:text-primary transition">Rooms</a>
                <a href="#about" class="hover:text-primary transition">About</a>
                <a href="#contact" class="hover:text-primary transition">Contact</a>
            </nav>
            <div class="flex items-center space-x-3">
                <a href="#search" class="bg-primary hover:bg-primary-dark text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition shadow-md shadow-primary/20">
                    Book Now
                </a>
                <button onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="md:hidden p-2 text-slate-600">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
            </div>
        </div>
        <div id="mobile-menu" class="hidden md:hidden border-t border-slate-100 bg-white">
            <nav class="flex flex-col px-4 py-3 space-y-1 text-sm font-medium text-slate-600">
                <a href="#home" class="px-4 py-3 rounded-lg hover:bg-slate-50">Home</a>
                <a href="#rooms" class="px-4 py-3 rounded-lg hover:bg-slate-50">Rooms</a>
                <a href="#about" class="px-4 py-3 rounded-lg hover:bg-slate-50">About</a>
                <a href="#contact" class="px-4 py-3 rounded-lg hover:bg-slate-50">Contact</a>
            </nav>
        </div>
    </header>

    @if(session('booking_success'))
        <div class="max-w-3xl mx-auto mt-4 px-4">
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 p-4 rounded-2xl text-sm flex items-center space-x-3">
                <i class="fa-solid fa-circle-check"></i>
                <span>{{ session('booking_success') }}</span>
            </div>
        </div>
    @endif
    @if($errors->any())
        <div class="max-w-3xl mx-auto mt-4 px-4">
            <div class="bg-rose-50 border border-rose-200 text-rose-600 p-4 rounded-2xl text-sm">
                @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
            </div>
        </div>
    @endif

    <!-- ===================== HERO ===================== -->
    <section id="home" class="relative hero-height overflow-hidden">
        <div class="absolute inset-0">
            @if(!empty($tenant->hero_image))
                <img src="{{ asset($tenant->hero_image) }}" alt="{{ $tenant->hotel_name }}" class="w-full h-full object-cover">
            @else
                <img src="https://images.unsplash.com/photo-1582719508461-905c673771fd?auto=format&fit=crop&w=1920&q=80" alt="Hotel" class="w-full h-full object-cover">
            @endif
            <div class="absolute inset-0 bg-gradient-to-r from-slate-900/80 via-slate-900/50 to-transparent"></div>
        </div>
        <div class="relative h-full max-w-7xl mx-auto px-4 sm:px-6 flex items-center">
            <div class="max-w-xl text-white space-y-5 md:space-y-6 text-center md:text-left mx-auto md:mx-0">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-tight tracking-tight">Your Perfect Stay<br>Awaits</h1>
                <p class="text-lg text-white/80 leading-relaxed max-w-md mx-auto md:mx-0">
                    {{ $tenant->description ?? ('Comfortable rooms, amazing views, and unforgettable experiences at ' . ($tenant->hotel_name ?? 'our hotel') . '.') }}
                </p>
                <a href="#search" class="inline-flex items-center space-x-2 bg-white text-primary hover:bg-slate-100 px-7 py-3.5 rounded-xl font-bold text-sm transition shadow-xl">
                    <span>Explore Rooms</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- ===================== SEARCH BAR (بحث توفر حقيقي) ===================== -->
    <div id="search" class="relative z-20 max-w-5xl mx-auto px-4 sm:px-6 -mt-16">
        <form action="{{ url('/hotel/' . $tenant->id . '/preview') }}" method="GET" class="bg-white rounded-2xl shadow-2xl border border-slate-100 p-4 sm:p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider flex items-center space-x-1.5">
                        <i class="fa-regular fa-calendar text-primary"></i><span>Check In</span>
                    </label>
                    <input type="date" name="check_in" min="{{ date('Y-m-d') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition" value="{{ $checkIn ?? date('Y-m-d') }}">
                </div>
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider flex items-center space-x-1.5">
                        <i class="fa-regular fa-calendar text-primary"></i><span>Check Out</span>
                    </label>
                    <input type="date" name="check_out" min="{{ date('Y-m-d') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition" value="{{ $checkOut ?? date('Y-m-d', strtotime('+2 days')) }}">
                </div>
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider flex items-center space-x-1.5">
                        <i class="fa-regular fa-user text-primary"></i><span>Guests</span>
                    </label>
                    <select name="guests" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition">
                        <option value="1" @selected(($guests ?? 2) == 1)>1 Adult</option>
                        <option value="2" @selected(($guests ?? 2) == 2)>2 Adults</option>
                        <option value="3" @selected(($guests ?? 2) == 3)>2 Adults + 1 Child</option>
                        <option value="4" @selected(($guests ?? 2) == 4)>2 Adults + 2 Children</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white font-bold py-3.5 rounded-xl transition shadow-lg shadow-primary/25 flex items-center justify-center space-x-2">
                        <i class="fa-solid fa-magnifying-glass"></i><span>Search</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- ===================== OUR ROOMS ===================== -->
    <section id="rooms" class="max-w-7xl mx-auto px-4 sm:px-6 py-20">
        <div class="text-center mb-12">
            <h2 class="text-3xl sm:text-4xl font-black text-slate-900">Our Rooms</h2>
            @if(!empty($checkIn) && !empty($checkOut))
                <p class="text-slate-500 mt-2">Available rooms from <span class="font-semibold text-slate-700">{{ $checkIn }}</span> to <span class="font-semibold text-slate-700">{{ $checkOut }}</span></p>
            @else
                <p class="text-slate-500 mt-2">Choose the perfect room for your stay</p>
            @endif
        </div>
        @if(isset($rooms) && $rooms->count() > 0)
            <div class="hidden md:grid md:grid-cols-3 gap-8">
                @foreach($rooms as $room)
                    <div class="group bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-xl transition duration-300">
                        <div class="overflow-hidden aspect-video">
                            @if($room->image)
                                <img src="{{ asset($room->image) }}" alt="{{ $room->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            @else
                                <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?auto=format&fit=crop&w=800&q=80" alt="{{ $room->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            @endif
                        </div>
                        <div class="p-5">
                            <h3 class="font-bold text-lg text-slate-900">{{ $room->name }}</h3>
                            <p class="text-sm text-slate-500 mt-1">{{ $room->description ?? ($room->type ?? 'Comfortable stay') }}</p>
                            <div class="flex items-center justify-between mt-4">
                                <span class="text-primary font-bold text-lg">${{ number_format($room->price, 0) }} <span class="text-sm font-normal text-slate-400">/ night</span></span>
                                <span class="text-xs bg-slate-100 text-slate-600 px-2.5 py-1 rounded-full">{{ $room->capacity }} Guests</span>
                            </div>
                            <button onclick="openBookingModal({{ $room->id }}, '{{ addslashes($room->name) }}', {{ (float) $room->price }})" class="mt-4 w-full bg-primary hover:bg-primary-dark text-white font-semibold py-2.5 rounded-xl text-sm transition">
                                Book This Room
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="md:hidden flex overflow-x-auto room-scroll gap-4 pb-4 -mx-4 px-4">
                @foreach($rooms as $room)
                    <div class="flex-shrink-0 w-[85%] bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-sm">
                        <div class="aspect-video overflow-hidden">
                            @if($room->image)
                                <img src="{{ asset($room->image) }}" class="w-full h-full object-cover" alt="{{ $room->name }}">
                            @else
                                <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?auto=format&fit=crop&w=800&q=80" class="w-full h-full object-cover" alt="{{ $room->name }}">
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-slate-900">{{ $room->name }}</h3>
                            <p class="text-primary font-bold mt-1">${{ number_format($room->price, 0) }} <span class="text-sm font-normal text-slate-400">/ night</span></p>
                            <button onclick="openBookingModal({{ $room->id }}, '{{ addslashes($room->name) }}', {{ (float) $room->price }})" class="mt-3 w-full bg-primary text-white font-semibold py-2 rounded-xl text-sm">
                                Book This Room
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16 bg-slate-50 rounded-2xl border border-slate-100">
                <i class="fa-solid fa-bed text-4xl text-slate-300 mb-4"></i>
                <p class="text-slate-500">
                    @if(!empty($checkIn) && !empty($checkOut))
                        No rooms available for these dates. Try different dates.
                    @else
                        No rooms available at the moment.
                    @endif
                </p>
            </div>
        @endif
    </section>

    <!-- ===================== ABOUT ===================== -->
    <section id="about" class="bg-slate-50 py-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center space-y-5">
            <h2 class="text-3xl sm:text-4xl font-black text-slate-900">About {{ $tenant->hotel_name ?? 'Us' }}</h2>
            <p class="text-slate-600 leading-relaxed text-lg">
                {{ $tenant->description ?? 'Experience luxury and comfort in the heart of the city. Your perfect stay starts here.' }}
            </p>
        </div>
    </section>

    <!-- ===================== CTA ===================== -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 py-16">
        <div class="bg-primary rounded-3xl p-10 md:p-14 text-center text-white relative overflow-hidden">
            <div class="relative z-10 space-y-5">
                <h2 class="text-3xl md:text-4xl font-black">Ready for an Unforgettable Stay?</h2>
                <p class="text-white/80 max-w-lg mx-auto">Book your room now and enjoy exclusive rates at {{ $tenant->hotel_name ?? 'our hotel' }}.</p>
                <a href="#rooms" class="inline-flex items-center space-x-2 bg-white text-primary hover:bg-slate-100 px-8 py-4 rounded-2xl font-bold text-sm transition shadow-xl">
                    <span>Book Now</span><i class="fa-solid fa-arrow-right"></i>
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
                        {{ $tenant->description ?? 'Experience luxury and comfort in the heart of the city. Your perfect stay starts here.' }}
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
                        @if(!empty($tenant->phone))
                        <li class="flex items-center space-x-2"><i class="fa-solid fa-phone text-xs"></i><span>{{ $tenant->phone }}</span></li>
                        @endif
                        @if(!empty($tenant->address))
                        <li class="flex items-center space-x-2"><i class="fa-solid fa-location-dot text-xs"></i><span>{{ $tenant->address }}</span></li>
                        @endif
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-white mb-4 text-sm uppercase tracking-wider">Payment Methods</h4>
                    <div class="flex flex-wrap gap-2">
                        <span class="bg-slate-800 px-3 py-1.5 rounded-lg text-xs font-semibold">Visa</span>
                        <span class="bg-slate-800 px-3 py-1.5 rounded-lg text-xs font-semibold">Mastercard</span>
                        <span class="bg-slate-800 px-3 py-1.5 rounded-lg text-xs font-semibold">PayPal</span>
                    </div>
                </div>
            </div>
            <div class="border-t border-slate-800 mt-10 pt-6 flex flex-col sm:flex-row justify-between items-center gap-3 text-xs text-slate-500">
                <p>© {{ date('Y') }} {{ $tenant->hotel_name ?? 'Grand View Hotel' }}. All rights reserved.</p>
                <p>Powered by SaaSPlatform</p>
            </div>
        </div>
    </footer>

    <!-- ===================== BOOKING MODAL ===================== -->
    <div id="booking-modal" class="hidden fixed inset-0 z-[100] bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 space-y-5 relative">
            <button onclick="closeBookingModal()" class="absolute top-4 left-4 text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
            <div>
                <h3 class="font-black text-xl text-slate-900" id="booking-room-name"></h3>
                <p class="text-primary font-bold" id="booking-room-price"></p>
            </div>
            <form action="{{ url('/hotel/' . $tenant->id . '/bookings') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="room_id" id="booking-room-id">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1">Check In</label>
                        <input type="date" name="check_in" required min="{{ date('Y-m-d') }}" value="{{ $checkIn ?? date('Y-m-d') }}" class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1">Check Out</label>
                        <input type="date" name="check_out" required min="{{ date('Y-m-d') }}" value="{{ $checkOut ?? date('Y-m-d', strtotime('+2 days')) }}" class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1">Full Name</label>
                    <input type="text" name="guest_name" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1">Email</label>
                        <input type="email" name="guest_email" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1">Phone</label>
                        <input type="text" name="guest_phone" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1">Guests</label>
                    <input type="number" name="guests_count" value="2" min="1" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm">
                </div>
                <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white font-bold py-3 rounded-xl transition">
                    Confirm Booking Request
                </button>
                <p class="text-xs text-slate-400 text-center">The hotel will confirm your booking shortly.</p>
            </form>
        </div>
    </div>

    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        });
        @if($errors->any())
            document.addEventListener('DOMContentLoaded', function() {
                // لو فيه خطأ حجز (مثلاً غرفة غير متاحة)، افتح المودال تلقائيًا لو القيم القديمة موجودة
            });
        @endif
    </script>
</body>
</html>
