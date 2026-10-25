<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>CampusPlace - @yield('title', 'Panel')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        /* Prevent body from scrolling horizontally */
        body { overflow-x: hidden; }
    </style>
</head>
<body class="bg-slate-50 font-sans antialiased text-gray-800" x-data="{ sidebarOpen: false }">
    
    <!-- Mobile Backdrop Overlay -->
    <div x-show="sidebarOpen" 
         x-transition:enter="transition-opacity ease-linear duration-300" 
         x-transition:enter-start="opacity-0" 
         x-transition:enter-end="opacity-100" 
         x-transition:leave="transition-opacity ease-linear duration-300" 
         x-transition:leave-start="opacity-100" 
         x-transition:leave-end="opacity-0" 
         @click="sidebarOpen = false" 
         class="fixed inset-0 z-20 bg-slate-900/60 backdrop-blur-sm md:hidden" 
         x-cloak></div>

    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar (Hidden on mobile, fixed on desktop) -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
               class="fixed inset-y-0 left-0 z-30 w-64 bg-slate-900 text-white transition-transform duration-300 transform md:relative md:translate-x-0 flex flex-col shadow-2xl md:shadow-none" 
               x-cloak>
            
            <!-- Sidebar Header (Logo) -->
            <div class="h-16 flex items-center px-6 border-b border-slate-800 bg-slate-900">
                <a href="/" class="flex items-center gap-2">
                    <img src="{{ asset('images/campusplace-icon.svg') }}" alt="" class="h-8 w-8">
                    <span class="text-xl font-bold text-white tracking-wide">Campus<span class="text-sky-400">Place</span></span>
                    <span class="ml-2 text-[10px] uppercase tracking-wider font-bold bg-slate-800 text-slate-300 px-2 py-0.5 rounded border border-slate-700">TPO</span>
                </a>
            </div>
            
            <!-- Sidebar Navigation Links -->
            <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
                    <a href="{{ route('college.dashboard') }}" class="block px-4 py-2.5 {{ request()->routeIs('college.dashboard') ? 'bg-sky-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} rounded-lg font-medium transition-all">Dashboard</a>
    <a href="{{ route('college.students.index') }}" class="block px-4 py-2.5 {{ request()->routeIs('college.students.*') ? 'bg-sky-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} rounded-lg font-medium transition-all">Manage Students</a>
    <a href="{{ route('college.jobs.index') }}" class="block px-4 py-2.5 {{ request()->routeIs('college.jobs.*') ? 'bg-sky-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} rounded-lg font-medium transition-all">Job Approvals</a>
    <a href="{{ route('college.blacklist.index') }}" class="block px-4 py-2.5 {{ request()->routeIs('college.blacklist.*') ? 'bg-sky-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} rounded-lg font-medium transition-all">Company Blacklist</a>
    <a href="{{ route('college.reports.index') }}" class="block px-4 py-2.5 {{ request()->routeIs('college.reports.*') ? 'bg-sky-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} rounded-lg font-medium transition-all">Reports</a>
    <a href="{{ route('college.notifications.create') }}" class="block px-4 py-2.5 {{ request()->routeIs('college.notifications.*') ? 'bg-sky-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} rounded-lg font-medium transition-all">Send Notification</a>
            </nav>
            
            <!-- Sidebar Footer (Logout) -->
            <div class="p-4 border-t border-slate-800 bg-slate-900">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-red-400 bg-red-400/10 hover:bg-red-400/20 rounded-lg font-medium transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            
            <!-- Top Header -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 md:px-8 z-10 shadow-sm">
                <div class="flex items-center">
                    <!-- Hamburger Menu (Mobile Only) -->
                    <button @click="sidebarOpen = true" class="md:hidden text-gray-500 hover:text-gray-700 focus:outline-none mr-4 p-2 rounded-md hover:bg-gray-100">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <h2 class="text-lg md:text-xl font-bold text-gray-800 truncate">@yield('header_title', 'Dashboard')</h2>
                </div>
                
                <div class="flex items-center space-x-3">
                    <span class="hidden md:inline text-sm text-gray-500 font-medium">Logged in as: <strong class="text-gray-800">{{ auth()->user()->name }}</strong></span>
                    <div class="h-9 w-9 bg-sky-100 text-sky-700 border border-sky-200 rounded-full flex items-center justify-center font-bold shadow-sm">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                </div>
            </header>

            <!-- Main Page Content -->
            <main class="flex-1 overflow-y-auto p-4 md:p-8">
                
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6 shadow-sm rounded-r-lg text-sm font-medium flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="bg-rose-50 border-l-4 border-rose-500 text-rose-700 p-4 mb-6 shadow-sm rounded-r-lg text-sm font-medium flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Content Slot -->
                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>
</html>