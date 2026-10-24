<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampusPlace - Student</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-50 font-sans antialiased">
    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        <aside class="w-64 bg-slate-900 text-white flex flex-col">
            <div class="h-16 flex items-center px-6 border-b border-slate-800">
                <img src="{{ asset('images/campusplace-icon.svg') }}" alt="" class="h-8 w-8 inline-block align-middle -mt-1 mr-2"><span class="text-xl font-bold text-blue-400 align-middle">CampusPlace</span>
                <span class="ml-2 text-xs bg-blue-900 text-blue-200 px-2 py-1 rounded">Student</span>
            </div>
            <nav class="flex-1 px-4 py-6 space-y-2">
                <a href="{{ route('student.dashboard') }}" class="block px-4 py-2 {{ request()->routeIs('student.dashboard') ? 'bg-blue-600 text-white' : 'hover:bg-slate-800 text-gray-300' }} rounded font-medium transition">Dashboard</a>
                <a href="{{ route('student.jobs.index') }}" class="block px-4 py-2 {{ request()->routeIs('student.jobs.*') ? 'bg-blue-600 text-white' : 'hover:bg-slate-800 text-gray-300' }} rounded font-medium transition">Browse Jobs</a>
                <a href="{{ route('student.applications.index') }}" class="block px-4 py-2 {{ request()->routeIs('student.applications.*') ? 'bg-blue-600 text-white' : 'hover:bg-slate-800 text-gray-300' }} rounded font-medium transition">My Applications</a>
                <a href="{{ route('student.profile.edit') }}" class="block px-4 py-2 {{ request()->routeIs('student.profile.*') ? 'bg-blue-600 text-white' : 'hover:bg-slate-800 text-gray-300' }} rounded font-medium transition">My Profile</a>
            </nav>
            <div class="p-4 border-t border-slate-800">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-red-400 hover:bg-slate-800 rounded font-medium transition">Logout</button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="h-16 bg-white border-b flex items-center justify-between px-8">
                <h2 class="text-xl font-semibold text-gray-800">Student Portal</h2>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600">Logged in as: <strong>{{ auth()->user()->name }}</strong></span>
                                    <div class="relative" x-data="{ open: false }">
                    @php
                        $unreadNotifications = \App\Models\Notification::where('user_id', auth()->id())->where('read_status', false)->latest()->get();
                    @endphp
                    <button @click="open = !open" class="relative p-2 text-gray-400 hover:text-gray-500 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        @if($unreadNotifications->count() > 0)
                            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-red-600 rounded-full">{{ $unreadNotifications->count() }}</span>
                        @endif
                    </button>
                    
                    <!-- Dropdown -->
                    <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-80 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50" style="display: none;">
                        <div class="py-1" role="menu" aria-orientation="vertical">
                            <div class="flex justify-between items-center px-4 py-2 border-b">
                                <span class="text-sm font-bold text-gray-700">Notifications</span>
                                @if($unreadNotifications->count() > 0)
                                    <form action="{{ route('notifications.mark-all') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-xs text-blue-600 hover:underline">Mark all as read</button>
                                    </form>
                                @endif
                            </div>
                            <div class="max-h-64 overflow-y-auto">
                                @forelse($unreadNotifications as $notif)
                                    <a href="{{ route('notifications.read', $notif->id) }}" class="block px-4 py-3 border-b hover:bg-gray-50 transition">
                                        <div class="flex justify-between">
                                            <p class="text-sm font-medium text-gray-900">{{ $notif->title }}</p>
                                            <span class="text-xs text-gray-400">{{ $notif->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">{{ $notif->message }}</p>
                                    </a>
                                @empty
                                    <div class="px-4 py-6 text-center text-sm text-gray-500">No new notifications</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
<div class="h-8 w-8 bg-blue-100 text-blue-700  rounded-full flex items-center justify-center font-bold">ST</div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-8">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>



