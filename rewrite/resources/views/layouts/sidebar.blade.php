<!-- Sidebar -->
<div x-data="{ sidebarOpen: window.innerWidth >= 768 }" @toggle-sidebar.window="sidebarOpen = !sidebarOpen" class="sidebar fixed inset-y-0 left-0 z-40 bg-white shadow-lg transform transition-all duration-300 ease-in-out overflow-hidden"
     :class="{ 'w-0': !sidebarOpen, 'w-64': sidebarOpen, '-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen }">

    <!-- Sidebar Header -->
    <div class="flex items-center justify-between h-16 px-4 bg-gray-50 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-800">Menu</h2>
        <!-- Close Button -->
        <button @click="sidebarOpen = false" class="text-gray-500 hover:text-gray-700 focus:outline-none">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <!-- Navigation Links -->
    <nav class="mt-8 px-4 mx-2">
        <div class="space-y-2">
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="block px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-md">
                {{ __('Dashboard') }}
            </x-nav-link>
            <!-- Manajemen Survei with Submenu -->
            <div x-data="{ subOpen: false }">
                <button @click="subOpen = !subOpen" class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-md focus:outline-none">
                    {{ __('Manajemen Survei') }}
                    <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': subOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="subOpen" x-transition class="ml-4 space-y-1">
                    <a href="{{ route('dashboard.survey-management.index') }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-md">Profil Responden</a>
                    <a href="{{ route('grafik.index3') }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-md">Rata-rata Gap per Indikator</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-md">Rata-rata Gap per Dimensi</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-md">Rekomendasi</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-md">Kepuasan</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-md">Loyalitas</a>


                </div>
            </div>
            <!-- Manajemen Evaluasi with Submenu -->
            <div x-data="{ subOpen: false }">
                <button @click="subOpen = !subOpen" class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-md focus:outline-none">
                    {{ __('Manajemen Evaluasi') }}
                    <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': subOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="subOpen" x-transition class="ml-4 space-y-1">
                    <a href="#" class="block px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-md">Buat Evaluasi Baru</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-md">Lihat Semua Evaluasi</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-md">Laporan Evaluasi</a>
                    <a href="{{ route('dashboard.customer-evaluation-management.index') }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-md">Kelola Data Evaluasi</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- User Section -->
    <div class="absolute bottom-0 left-0 right-0 pb-3 border-t border-gray-200 bg-white">
        <div x-data="{ userMenuOpen: false }" class="px-4 pt-4">
            <button @click="userMenuOpen = !userMenuOpen" class="flex items-center justify-between w-full py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-md focus:outline-none">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                            <span class="text-sm font-medium text-gray-700">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                        </div>
                    </div>
                    <div class="ml-3 text-left">
                        <div class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': userMenuOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div x-show="userMenuOpen" x-transition class="mt-2 space-y-1">
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-md">
                    {{ __('Edit Profile') }}
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-md">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Invisible overlay for click outside -->
<div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-30" x-cloak></div>
