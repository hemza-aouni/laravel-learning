<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tenant->hotel_name }} | Management Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }
    </script>
</head>
<body class="bg-slate-950 text-slate-100 font-sans antialiased">

    <div class="flex flex-col md:flex-row h-screen overflow-hidden">
        
        <!-- Mobile Header Bar -->
        <div class="md:hidden flex items-center justify-between bg-slate-900 border-b border-slate-800 p-4">
            <div class="flex items-center space-x-3">
                <div class="bg-indigo-600 p-2 rounded-xl text-white">
                    <i class="fa-solid fa-hotel"></i>
                </div>
                <span class="font-bold text-lg truncate">{{ $tenant->hotel_name }}</span>
            </div>
            <button onclick="toggleMobileMenu()" class="text-slate-400 hover:text-white focus:outline-none p-2">
                <i class="fa-solid fa-bars text-xl"></i>
            </button>
        </div>

        <!-- Sidebar (Desktop & Mobile Dropdown) -->
        <aside id="mobile-menu" class="hidden md:flex flex-col w-full md:w-64 bg-slate-900 border-r border-slate-800 justify-between absolute md:relative z-50 h-full md:h-auto">
            <div>
                <div class="p-6 border-b border-slate-800 hidden md:flex items-center space-x-3">
                    <div class="bg-indigo-600 p-2 rounded-xl text-white">
                        <i class="fa-solid fa-hotel"></i>
                    </div>
                    <span class="font-bold text-lg truncate">{{ $tenant->hotel_name }}</span>
                </div>
                <nav class="p-4 space-y-2 text-sm font-medium">
                    <a href="#overview" onclick="toggleMobileMenu()" class="flex items-center space-x-3 px-4 py-3 rounded-xl bg-indigo-600 text-white"><i class="fa-solid fa-chart-pie w-5"><span>Overview</span></i></a>
                    <a href="#rooms" onclick="toggleMobileMenu()" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-400 hover:bg-slate-800 hover:text-white transition"><i class="fa-solid fa-bed w-5"></i><span>Rooms & Bookings</span></a>
                    <a href="#staff" onclick="toggleMobileMenu()" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-400 hover:bg-slate-800 hover:text-white transition"><i class="fa-solid fa-users w-5"></i><span>Staff Management</span></a>
                    <a href="#invoices" onclick="toggleMobileMenu()" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-400 hover:bg-slate-800 hover:text-white transition"><i class="fa-solid fa-file-invoice-dollar w-5"></i><span>Invoices & Billing</span></a>
                    <a href="#domains" onclick="toggleMobileMenu()" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-400 hover:bg-slate-800 hover:text-white transition"><i class="fa-solid fa-globe w-5"></i><span>Custom Domain</span></a>
                    <a href="#settings" onclick="toggleMobileMenu()" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-400 hover:bg-slate-800 hover:text-white transition"><i class="fa-solid fa-gear w-5"></i><span>Settings & Appearance</span></a>
                </nav>
            </div>
            <div class="p-4 border-t border-slate-800">
                <a href="/" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-rose-400 hover:bg-rose-500/10 transition text-sm font-medium"><i class="fa-solid fa-right-from-bracket w-5"></i><span>Sign Out</span></a>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 overflow-y-auto p-4 md:p-8">
            
            <!-- Top Header with Eye Preview Icon -->
            <div class="flex flex-col sm:flex-row justify-between items-center mb-8 bg-slate-900 border border-slate-800 p-4 rounded-2xl gap-4">
                <div>
                    <h1 class="text-xl font-black">Dashboard: {{ $tenant->hotel_name }}</h1>
                    <p class="text-slate-400 text-xs">Manage your hotel infrastructure seamlessly.</p>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- أيقونة معاينة الموقع في الهيدر -->
                    <a href="/hotel/{{ $tenant->id }}/preview" target="_blank" title="معاينة الموقع العام" class="bg-indigo-600/20 hover:bg-indigo-600/30 text-indigo-400 border border-indigo-500/30 p-2.5 rounded-xl transition flex items-center space-x-2 text-sm font-semibold px-4">
                        <i class="fa-solid fa-eye"></i>
                        <span>معاينة الموقع</span>
                    </a>
                    <div class="flex items-center space-x-2">
                        <span class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="text-xs font-semibold text-slate-300">Active</span>
                    </div>
                </div>
            </div>

            <!-- Trial / Subscription Alert Bar -->
            @php
                $trialExpires = \Carbon\Carbon::parse($tenant->trial_ends_at);
                $isExpired = now()->greaterThan($trialExpires);
            @endphp

            @if($isExpired)
                <div class="bg-rose-500/10 border border-rose-500/20 text-rose-400 p-4 rounded-2xl mb-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-triangle-exclamation text-xl"></i>
                        <div>
                            <p class="font-bold">Your Free Trial Has Expired!</p>
                            <p class="text-xs text-rose-300">Please upgrade your subscription to keep your hotel active.</p>
                        </div>
                    </div>
                    <button onclick="document.getElementById('billing').scrollIntoView({behavior: 'smooth'})" class="bg-rose-600 hover:bg-rose-500 text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition">Upgrade Now</button>
                </div>
            @else
                <div class="bg-indigo-500/10 border border-indigo-500/25 text-indigo-300 p-4 rounded-2xl mb-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-clock text-xl text-indigo-400"></i>
                        <div>
                            <p class="font-bold">Free Trial Active</p>
                            <p class="text-xs text-indigo-300">Your trial period ends in {{ now()->diffInHours($trialExpires) }} hours.</p>
                        </div>
                    </div>
                    <span class="bg-indigo-600 text-white text-xs px-3 py-1.5 rounded-lg font-semibold">Standard Tier</span>
                </div>
            @endif

            <!-- Stats Grid -->
            <div id="overview" class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-10">
                <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl">
                    <div class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-2">Total Rooms</div>
                    <div class="text-3xl font-black">32</div>
                </div>
                <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl">
                    <div class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-2">Active Bookings</div>
                    <div class="text-3xl font-black text-indigo-400">18</div>
                </div>
                <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl">
                    <div class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-2">Staff Members</div>
                    <div class="text-3xl font-black text-emerald-400">7</div>
                </div>
                <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl">
                    <div class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-2">Monthly Revenue</div>
                    <div class="text-3xl font-black text-violet-400">$12,450</div>
                </div>
            </div>

            <!-- Rooms Management Section (إضافة، حذف، وعرض الطلبات) -->
            <div id="rooms" class="bg-slate-900 border border-slate-800 p-6 md:p-8 rounded-2xl mb-8">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                    <div>
                        <h2 class="text-xl font-bold">Rooms & Bookings Management</h2>
                        <p class="text-slate-400 text-sm">Add new suites, remove rooms, and review incoming guest requests.</p>
                    </div>
                    <button onclick="alert('Open Add Room Modal')" class="bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition flex items-center space-x-2">
                        <i class="fa-solid fa-plus"></i>
                        <span>Add New Room</span>
                    </button>
                </div>

                <!-- قائمة الغرف والطلبات الحالية -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-300">
                        <thead class="bg-slate-950 text-xs uppercase text-slate-400 border-b border-slate-800">
                            <tr>
                                <th class="p-4">Room Name / Type</th>
                                <th class="p-4">Price / Night</th>
                                <th class="p-4">Status</th>
                                <th class="p-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                            <tr>
                                <td class="p-4 font-semibold text-white">Deluxe Ocean Suite #101</td>
                                <td class="p-4 text-indigo-400 font-bold">$180</td>
                                <td class="p-4"><span class="bg-emerald-500/10 text-emerald-400 text-xs px-2.5 py-1 rounded-full">Available</span></td>
                                <td class="p-4 space-x-2">
                                    <button onclick="alert('Room edited!')" class="text-indigo-400 hover:text-indigo-300"><i class="fa-solid fa-pen"></i></button>
                                    <button onclick="alert('Room deleted!')" class="text-rose-400 hover:text-rose-300"><i class="fa-solid fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td class="p-4 font-semibold text-white">Executive Royal Room #204</td>
                                <td class="p-4 text-indigo-400 font-bold">$120</td>
                                <td class="p-4"><span class="bg-amber-500/10 text-amber-400 text-xs px-2.5 py-1 rounded-full">Booked / Request</span></td>
                                <td class="p-4 space-x-2">
                                    <button onclick="alert('Room edited!')" class="text-indigo-400 hover:text-indigo-300"><i class="fa-solid fa-pen"></i></button>
                                    <button onclick="alert('Room deleted!')" class="text-rose-400 hover:text-rose-300"><i class="fa-solid fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Staff Management Section -->
            <div id="staff" class="bg-slate-900 border border-slate-800 p-6 md:p-8 rounded-2xl mb-8">
                <h2 class="text-xl font-bold mb-2">Staff Members</h2>
                <p class="text-slate-400 text-sm mb-6">Manage receptionists, housekeeping, and management permissions.</p>
                <div class="flex justify-between items-center bg-slate-950 p-4 rounded-xl border border-slate-800">
                    <div class="flex items-center space-x-3">
                        <div class="bg-emerald-500/10 text-emerald-400 p-3 rounded-xl"><i class="fa-solid fa-user-tie"></i></div>
                        <div>
                            <p class="font-bold text-sm">Aimen Aouni</p>
                            <p class="text-xs text-slate-400">Head Receptionist</p>
                        </div>
                    </div>
                    <button class="text-rose-400 hover:text-rose-300 text-sm font-semibold">Remove</button>
                </div>
            </div>

            <!-- Billing & Subscription Section -->
            <div id="invoices" class="bg-slate-900 border border-slate-800 p-6 md:p-8 rounded-2xl mb-8">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-bold">Subscription & Billing</h2>
                        <p class="text-slate-400 text-sm">Manage your billing details and renew your hotel SaaS subscription.</p>
                    </div>
                    <span class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs font-semibold px-3 py-1 rounded-full">Secure Payment</span>
                </div>
                <div class="grid md:grid-cols-2 gap-6 items-center">
                    <div class="bg-slate-950 border border-slate-800 p-6 rounded-xl">
                        <div class="text-sm font-semibold text-indigo-400 mb-1">Current Plan: Professional Hotel</div>
                        <div class="text-2xl font-black mb-4">$49 <span class="text-xs text-slate-500 font-normal">/ month</span></div>
                        <ul class="text-sm text-slate-400 space-y-2 mb-6">
                            <li><i class="fa-solid fa-check text-emerald-400 mr-2"></i> Unlimited Rooms & Bookings</li>
                            <li><i class="fa-solid fa-check text-emerald-400 mr-2"></i> Custom Domain Support</li>
                            <li><i class="fa-solid fa-check text-emerald-400 mr-2"></i> Isolated Database Security</li>
                        </ul>
                    </div>
                    <div class="space-y-4">
                        <div id="billing">
                            <label class="block text-xs font-medium text-slate-400 mb-1">Card Information</label>
                            <input type="text" placeholder="4242 •••• •••• 4242" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-indigo-500 mb-4">
                        </div>
                        <button type="button" onclick="alert('Payment simulation successful!')" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-3 rounded-xl text-sm shadow-lg shadow-indigo-600/30 transition">
                            Pay & Renew Subscription ($49)
                        </button>
                    </div>
                </div>
            </div>

            <!-- Custom Domain Section -->
            <div id="domains" class="bg-slate-900 border border-slate-800 p-6 md:p-8 rounded-2xl mb-8">
                <h2 class="text-xl font-bold mb-2">Custom Domain Management</h2>
                <p class="text-slate-400 text-sm mb-6">Connect your own custom domain (e.g. www.myhotel.com).</p>
                <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                    <input type="text" placeholder="www.myhotel.com" class="flex-1 bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-indigo-500">
                    <button type="button" onclick="alert('Custom domain saved!')" class="bg-slate-800 hover:bg-slate-700 text-white px-6 py-3 rounded-xl text-sm font-semibold transition">Connect Domain</button>
                </div>
            </div>

            <!-- Settings & Appearance Section -->
            <div id="settings" class="bg-slate-900 border border-slate-800 p-6 md:p-8 rounded-2xl mb-8">
                <h2 class="text-xl font-bold mb-2">Settings & Appearance</h2>
                <p class="text-slate-400 text-sm mb-6">Customize your hotel public identity, logo, and brand theme.</p>
                <form action="#" method="POST" class="space-y-4">
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-slate-400 mb-1">Hotel Display Name</label>
                            <input type="text" value="{{ $tenant->hotel_name }}" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-400 mb-1">Contact Email</label>
                            <input type="email" value="{{ $tenant->email }}" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-indigo-500">
                        </div>
                    </div>
                    <button type="button" onclick="alert('Settings updated successfully!')" class="bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-3 rounded-xl text-sm font-semibold transition">Save Changes</button>
                </form>
            </div>

        </main>
    </div>

</body>
</html>
