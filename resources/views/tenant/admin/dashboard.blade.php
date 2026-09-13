<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tenant->hotel_name }} | Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
            document.getElementById('sidebar-overlay').classList.toggle('hidden');
        }
        function switchSection(id) {
            document.querySelectorAll('.tenant-section').forEach(el => el.classList.add('hidden'));
            const target = document.getElementById(id);
            if (target) target.classList.remove('hidden');
            document.querySelectorAll('.nav-item').forEach(el => {
                el.classList.remove('bg-blue-600', 'text-white');
                el.classList.add('text-slate-600', 'hover:bg-slate-100');
            });
            const active = document.querySelector('[data-section="'+id+'"]');
            if (active) {
                active.classList.add('bg-blue-600', 'text-white');
                active.classList.remove('text-slate-600', 'hover:bg-slate-100');
            }
            if (window.innerWidth < 768) {
                document.getElementById('sidebar').classList.add('-translate-x-full');
                document.getElementById('sidebar-overlay').classList.add('hidden');
            }
            history.replaceState(null, null, '#' + id);
        }
        document.addEventListener('DOMContentLoaded', function() {
            const hash = window.location.hash.replace('#', '') || 'section-overview';
            if (document.getElementById(hash)) switchSection(hash);
        });
    </script>
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased">

    <div id="sidebar-overlay" onclick="toggleSidebar()" class="hidden fixed inset-0 bg-black/40 z-40 md:hidden"></div>

    <div class="flex min-h-screen">

        <!-- ========== SIDEBAR ========== -->
        <aside id="sidebar" class="fixed md:sticky top-0 left-0 z-50 w-72 h-screen bg-white border-r border-slate-200 flex flex-col transition-transform duration-300 -translate-x-full md:translate-x-0">
            <div class="p-5 border-b border-slate-100">
                <div class="flex items-center space-x-3">
                    <div class="w-11 h-11 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                        {{ strtoupper(substr($tenant->hotel_name ?? 'H', 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="font-bold text-sm truncate">{{ $tenant->hotel_name }}</p>
                        <p class="text-xs text-slate-500">Hotel Admin</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 p-4 space-y-1 overflow-y-auto text-sm font-medium">
                <button data-section="section-overview" onclick="switchSection('section-overview')" class="nav-item w-full flex items-center space-x-3 px-4 py-3 rounded-xl bg-blue-600 text-white transition">
                    <i class="fa-solid fa-gauge-high w-5 text-center"></i><span>Dashboard</span>
                </button>
                <button data-section="section-rooms" onclick="switchSection('section-rooms')" class="nav-item w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-100 transition">
                    <i class="fa-solid fa-bed w-5 text-center"></i><span>Rooms Management</span>
                </button>
                <button data-section="section-bookings" onclick="switchSection('section-bookings')" class="nav-item w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-100 transition">
                    <i class="fa-solid fa-calendar-check w-5 text-center"></i><span>Room Bookings</span>
                </button>
                <button data-section="section-settings" onclick="switchSection('section-settings')" class="nav-item w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-100 transition">
                    <i class="fa-solid fa-palette w-5 text-center"></i><span>Website Settings</span>
                </button>
                <button data-section="section-domain" onclick="switchSection('section-domain')" class="nav-item w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-100 transition">
                    <i class="fa-solid fa-globe w-5 text-center"></i><span>Custom Domain</span>
                </button>
            </nav>

            <div class="p-4 border-t border-slate-100 space-y-2">
                <a href="/hotel/{{ $tenant->id }}/preview" target="_blank" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-blue-600 hover:bg-blue-50 transition text-sm font-medium">
                    <i class="fa-solid fa-eye w-5 text-center"></i><span>Preview Website</span>
                </a>
                <a href="/" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-rose-500 hover:bg-rose-50 transition text-sm font-medium">
                    <i class="fa-solid fa-right-from-bracket w-5 text-center"></i><span>Exit</span>
                </a>
            </div>
        </aside>

        <!-- ========== MAIN ========== -->
        <div class="flex-1 flex flex-col min-w-0">
            <header class="sticky top-0 z-30 bg-white border-b border-slate-200 px-4 py-3 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <button onclick="toggleSidebar()" class="md:hidden p-2 text-slate-600 hover:bg-slate-100 rounded-lg">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                    <h1 class="font-bold text-lg">{{ $tenant->hotel_name }}</h1>
                </div>
                <a href="/hotel/{{ $tenant->id }}/preview" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-4 py-2 rounded-xl flex items-center space-x-2 transition">
                    <i class="fa-solid fa-eye"></i><span class="hidden sm:inline">Preview Site</span>
                </a>
            </header>

            <main class="flex-1 p-4 md:p-8 overflow-y-auto">

                @if(session('success'))
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 p-4 rounded-2xl mb-6 text-sm flex items-center space-x-3">
                        <i class="fa-solid fa-circle-check"></i><span>{{ session('success') }}</span>
                    </div>
                @endif
                @if($errors->any())
                    <div class="bg-rose-50 border border-rose-200 text-rose-600 p-4 rounded-2xl mb-6 text-sm">
                        @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
                    </div>
                @endif

                <!-- ===== OVERVIEW ===== -->
                <div id="section-overview" class="tenant-section space-y-6">
                    <div>
                        <h2 class="text-2xl font-black text-slate-900">Dashboard</h2>
                        <p class="text-slate-500 text-sm">Welcome back. Here's what's happening.</p>
                    </div>

                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="bg-blue-600 text-white rounded-2xl p-5 shadow-lg shadow-blue-600/20">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-blue-100 text-xs font-semibold uppercase">Rooms</p>
                                    <p class="text-3xl font-black mt-1">{{ $rooms->count() ?? 0 }}</p>
                                </div>
                                <i class="fa-solid fa-hotel text-3xl text-blue-300"></i>
                            </div>
                        </div>
                        <div class="bg-sky-500 text-white rounded-2xl p-5 shadow-lg shadow-sky-500/20">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sky-100 text-xs font-semibold uppercase">Bookings</p>
                                    <p class="text-3xl font-black mt-1">{{ $bookings->count() ?? 0 }}</p>
                                </div>
                                <i class="fa-solid fa-calendar-days text-3xl text-sky-300"></i>
                            </div>
                        </div>
                        <div class="bg-violet-600 text-white rounded-2xl p-5 shadow-lg shadow-violet-600/20">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-violet-100 text-xs font-semibold uppercase">Active Rooms</p>
                                    <p class="text-3xl font-black mt-1">{{ $rooms->where('is_active', true)->count() ?? 0 }}</p>
                                </div>
                                <i class="fa-solid fa-door-open text-3xl text-violet-300"></i>
                            </div>
                        </div>
                        <div class="bg-emerald-500 text-white rounded-2xl p-5 shadow-lg shadow-emerald-500/20">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-emerald-100 text-xs font-semibold uppercase">Status</p>
                                    <p class="text-lg font-black mt-1">
                                        @if(isset($tenant->trial_ends_at) && now()->lt($tenant->trial_ends_at))
                                            Trial
                                        @else
                                            Active
                                        @endif
                                    </p>
                                </div>
                                <i class="fa-solid fa-circle-check text-3xl text-emerald-300"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl border border-slate-200 p-6">
                        <h3 class="font-bold mb-4">Quick Actions</h3>
                        <div class="flex flex-wrap gap-3">
                            <button onclick="switchSection('section-rooms')" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition">
                                <i class="fa-solid fa-plus mr-2"></i>Add Room
                            </button>
                            <a href="/hotel/{{ $tenant->id }}/preview" target="_blank" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-5 py-2.5 rounded-xl text-sm font-semibold transition">
                                <i class="fa-solid fa-eye mr-2"></i>Preview Website
                            </a>
                            <button onclick="switchSection('section-settings')" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-5 py-2.5 rounded-xl text-sm font-semibold transition">
                                <i class="fa-solid fa-palette mr-2"></i>Website Settings
                            </button>
                        </div>
                    </div>
                </div>

                <!-- ===== ROOMS ===== -->
                <div id="section-rooms" class="tenant-section hidden space-y-6">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <h2 class="text-2xl font-black text-slate-900">Rooms Management</h2>
                            <p class="text-slate-500 text-sm">Rooms appear automatically on your public website.</p>
                        </div>
                        <button onclick="document.getElementById('add-room-box').classList.toggle('hidden')" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition flex items-center space-x-2">
                            <i class="fa-solid fa-plus"></i><span>Add Room</span>
                        </button>
                    </div>

                    <div id="add-room-box" class="hidden bg-white rounded-2xl border border-slate-200 p-6 space-y-4">
                        <h3 class="font-bold text-blue-600">Add New Room</h3>
                        <form action="/hotel/{{ $tenant->id }}/rooms" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 mb-1">Room Name *</label>
                                    <input type="text" name="name" required placeholder="Deluxe Ocean Suite" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 mb-1">Type</label>
                                    <select name="type" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                                        <option>Standard</option>
                                        <option>Deluxe</option>
                                        <option>Suite</option>
                                        <option>Presidential</option>
                                    </select>
                                </div>
                            </div>
                            <div class="grid md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 mb-1">Price / Night ($) *</label>
                                    <input type="number" name="price" step="0.01" required placeholder="120" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 mb-1">Capacity</label>
                                    <input type="number" name="capacity" value="2" min="1" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 mb-1">Image</label>
                                    <input type="file" name="image" accept="image/*" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 mb-1">Description</label>
                                <textarea name="description" rows="2" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/30"></textarea>
                            </div>
                            <div class="flex items-center justify-between">
                                <label class="flex items-center space-x-2 text-sm">
                                    <input type="checkbox" name="is_active" value="1" checked class="rounded border-slate-300">
                                    <span>Show on website</span>
                                </label>
                                <button type="submit" class="bg-emerald-600 hover:bg-emerald-500 text-white font-semibold px-6 py-2.5 rounded-xl text-sm transition">Save Room</button>
                            </div>
                        </form>
                    </div>

                    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="bg-slate-50 text-xs uppercase text-slate-500 border-b border-slate-200">
                                    <tr>
                                        <th class="p-4">Room</th><th class="p-4">Type</th><th class="p-4">Price</th>
                                        <th class="p-4">Capacity</th><th class="p-4">Status</th><th class="p-4">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse($rooms ?? [] as $room)
                                        <tr class="hover:bg-slate-50">
                                            <td class="p-4">
                                                <div class="flex items-center space-x-3">
                                                    @if($room->image)
                                                        <img src="{{ asset($room->image) }}" class="w-12 h-12 rounded-xl object-cover" alt="">
                                                    @else
                                                        <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center text-slate-400"><i class="fa-solid fa-bed"></i></div>
                                                    @endif
                                                    <span class="font-semibold">{{ $room->name }}</span>
                                                </div>
                                            </td>
                                            <td class="p-4 text-slate-500">{{ $room->type ?? '-' }}</td>
                                            <td class="p-4 font-bold text-blue-600">${{ number_format($room->price, 0) }}</td>
                                            <td class="p-4">{{ $room->capacity }}</td>
                                            <td class="p-4">
                                                @if($room->is_active)
                                                    <span class="bg-emerald-50 text-emerald-600 text-xs px-2.5 py-1 rounded-full font-semibold">Active</span>
                                                @else
                                                    <span class="bg-slate-100 text-slate-500 text-xs px-2.5 py-1 rounded-full">Hidden</span>
                                                @endif
                                            </td>
                                            <td class="p-4">
                                                <form action="/hotel/{{ $tenant->id }}/rooms/{{ $room->id }}" method="POST" onsubmit="return confirm('Delete this room?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-rose-500 hover:text-rose-600"><i class="fa-solid fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="6" class="p-10 text-center text-slate-400">No rooms yet. Click "Add Room" to create one.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- ===== BOOKINGS ===== -->
                <div id="section-bookings" class="tenant-section hidden space-y-6">
                    <div>
                        <h2 class="text-2xl font-black text-slate-900">Room Bookings</h2>
                        <p class="text-slate-500 text-sm">Incoming reservations from your website.</p>
                    </div>
                    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="bg-slate-50 text-xs uppercase text-slate-500 border-b border-slate-200">
                                    <tr>
                                        <th class="p-4">Guest</th><th class="p-4">Room</th><th class="p-4">Check In</th>
                                        <th class="p-4">Check Out</th><th class="p-4">Total</th><th class="p-4">Status</th><th class="p-4">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse($bookings ?? [] as $booking)
                                        <tr class="hover:bg-slate-50">
                                            <td class="p-4">
                                                <div class="font-semibold">{{ $booking->guest_name }}</div>
                                                <div class="text-xs text-slate-400">
                                                    {{ $booking->guest_email }}
                                                    @if($booking->guest_phone) · {{ $booking->guest_phone }} @endif
                                                </div>
                                            </td>
                                            <td class="p-4">{{ $booking->room->name ?? '—' }}</td>
                                            <td class="p-4">{{ \Carbon\Carbon::parse($booking->check_in)->format('Y-m-d') }}</td>
                                            <td class="p-4">{{ \Carbon\Carbon::parse($booking->check_out)->format('Y-m-d') }}</td>
                                            <td class="p-4 font-bold text-blue-600">${{ number_format($booking->total_price ?? 0, 0) }}</td>
                                            <td class="p-4">
                                                @if($booking->status === 'confirmed')
                                                    <span class="bg-emerald-50 text-emerald-600 text-xs px-2.5 py-1 rounded-full font-semibold">Confirmed</span>
                                                @elseif($booking->status === 'cancelled')
                                                    <span class="bg-rose-50 text-rose-500 text-xs px-2.5 py-1 rounded-full font-semibold">Cancelled</span>
                                                @else
                                                    <span class="bg-amber-50 text-amber-600 text-xs px-2.5 py-1 rounded-full font-semibold">Pending</span>
                                                @endif
                                            </td>
                                            <td class="p-4">
                                                <div class="flex items-center space-x-3">
                                                    @if($booking->status !== 'confirmed')
                                                    <form action="/hotel/{{ $tenant->id }}/bookings/{{ $booking->id }}/status" method="POST">
                                                        @csrf @method('PUT')
                                                        <input type="hidden" name="status" value="confirmed">
                                                        <button title="Confirm" class="text-emerald-600 hover:text-emerald-700"><i class="fa-solid fa-check"></i></button>
                                                    </form>
                                                    @endif
                                                    @if($booking->status !== 'cancelled')
                                                    <form action="/hotel/{{ $tenant->id }}/bookings/{{ $booking->id }}/status" method="POST">
                                                        @csrf @method('PUT')
                                                        <input type="hidden" name="status" value="cancelled">
                                                        <button title="Cancel" class="text-amber-600 hover:text-amber-700"><i class="fa-solid fa-ban"></i></button>
                                                    </form>
                                                    @endif
                                                    <form action="/hotel/{{ $tenant->id }}/bookings/{{ $booking->id }}" method="POST" onsubmit="return confirm('Delete this booking?');">
                                                        @csrf @method('DELETE')
                                                        <button title="Delete" class="text-rose-500 hover:text-rose-600"><i class="fa-solid fa-trash"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="7" class="p-10 text-center text-slate-400">No bookings yet. When guests book from your website, they will appear here.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- ===== WEBSITE SETTINGS ===== -->
                <div id="section-settings" class="tenant-section hidden space-y-6">
                    <div>
                        <h2 class="text-2xl font-black text-slate-900">Website Settings</h2>
                        <p class="text-slate-500 text-sm">Customize how your public hotel page looks.</p>
                    </div>
                    <form action="/hotel/{{ $tenant->id }}/settings" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl border border-slate-200 p-6 space-y-5">
                        @csrf @method('PUT')
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 mb-1">Hotel Display Name</label>
                                <input type="text" name="hotel_name" value="{{ $tenant->hotel_name }}" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 mb-1">Contact Email</label>
                                <input type="email" name="email" value="{{ $tenant->email }}" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                            </div>
                        </div>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 mb-1">Phone</label>
                                <input type="text" name="phone" value="{{ $tenant->phone ?? '' }}" placeholder="+1 555 000 000" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 mb-1">Address</label>
                                <input type="text" name="address" value="{{ $tenant->address ?? '' }}" placeholder="123 Ocean Drive" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1">Short Description (shown on website)</label>
                            <textarea name="description" rows="3" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/30" placeholder="Comfortable rooms with amazing views...">{{ $tenant->description ?? '' }}</textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1">Hero Background Image (shown at top of your website)</label>
                            @if(!empty($tenant->hero_image))
                                <img src="{{ asset($tenant->hero_image) }}" class="h-24 rounded-xl mb-2 border border-slate-200">
                            @endif
                            <input type="file" name="hero_image" accept="image/*" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm">
                        </div>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-xl text-sm transition">Save Settings</button>
                    </form>
                </div>

                <!-- ===== DOMAIN ===== -->
                <div id="section-domain" class="tenant-section hidden space-y-6">
                    <div>
                        <h2 class="text-2xl font-black text-slate-900">Custom Domain</h2>
                        <p class="text-slate-500 text-sm">Connect your own domain (e.g. www.myhotel.com).</p>
                    </div>
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 space-y-4">
                        <div class="flex flex-col sm:flex-row gap-3">
                            <input type="text" placeholder="www.myhotel.com" class="flex-1 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                            <button type="button" onclick="alert('Domain request submitted. Super admin will review it.')" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl text-sm transition">Request Domain</button>
                        </div>
                        <p class="text-xs text-slate-400">After approval, point your DNS A record to our server IP.</p>
                    </div>
                </div>

            </main>
        </div>
    </div>
</body>
</html>
