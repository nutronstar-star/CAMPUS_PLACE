<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampusPlace - @yield('title', 'Panel')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">
    
    <!-- Alpine state for mobile sidebar -->
    <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">
        
        <!-- Mobile Overlay (closes sidebar when clicked) -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-20 bg-black opacity-50 md:hidden" x-cloak></div>

        <!-- Sidebar (Hidden on mobile, slides in when toggled) -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
               class="fixed inset-y-0 left-0 z-30 w-64 bg-slate-900 text-white transition-transform duration-300 transform md:relative md:translate-x-0 flex flex-col">
            
            <div class="h-16 flex items-center px-6 border-b border-slate-800">
                <span class="text-xl font-bold text-indigo-400">CampusPlace</span>
                <span class="ml-2 text-xs bg-indigo-900 text-indigo-200 px-2 py-1 rounded">TPO</span>
            </div>
            
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                    <a href="{{ route('college.dashboard') }}" class="block px-4 py-2 {{ request()->routeIs('college.dashboard') ? 'bg-sky-600 text-white' : 'hover:bg-slate-800 text-gray-300' }} rounded font-medium">Dashboard</a>
    <a href="{{ route('college.students.index') }}" class="block px-4 py-2 {{ request()->routeIs('college.students.*') ? 'bg-sky-600 text-white' : 'hover:bg-slate-800 text-gray-300' }} rounded font-medium">Manage Students</a>
    <a href="{{ route('college.jobs.index') }}" class="block px-4 py-2 {{ request()->routeIs('college.jobs.*') ? 'bg-sky-600 text-white' : 'hover:bg-slate-800 text-gray-300' }} rounded font-medium">Job Approvals</a>
    <a href="{{ route('college.blacklist.index') }}" class="block px-4 py-2 {{ request()->routeIs('college.blacklist.*') ? 'bg-sky-600 text-white' : 'hover:bg-slate-800 text-gray-300' }} rounded font-medium">Company Blacklist</a>
            </nav>
            
            <div class="p-4 border-t border-slate-800">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-red-400 hover:bg-slate-800 rounded font-medium transition">Logout</button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden w-full">
            
            <!-- Top Header -->
            <header class="h-16 bg-white border-b flex items-center justify-between px-4 md:px-8">
                <div class="flex items-center">
                    <!-- Hamburger Menu (Mobile Only) -->
                    <button @click="sidebarOpen = true" class="md:hidden text-gray-500 hover:text-gray-700 focus:outline-none mr-4">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <h2 class="text-lg md:text-xl font-semibold text-gray-800 truncate">@yield('header_title', 'Dashboard')</h2>
                </div>
                
                <div class="flex items-center space-x-4">
                    <span class="hidden md:inline text-sm text-gray-600">Logged in as: <strong>{{ auth()->user()->name }}</strong></span>
                    <div class="h-8 w-8 bg-indigo-100 text-indigo-700 rounded-full flex items-center justify-center font-bold">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                </div>
            </header>

            <!-- Main Content Page -->
            <main class="flex-1 overflow-y-auto p-4 md:p-8">
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 shadow-sm">{{ session('error') }}</div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
    
    <style>
        [x-cloak] { display: none !important; }
        /* Ensure tables don't break mobile layout */
        table { display: block; overflow-x: auto; white-space: nowrap; }
        @media (min-width: 768px) { table { display: table; white-space: normal; } }
    </style>
</body>
</html>
