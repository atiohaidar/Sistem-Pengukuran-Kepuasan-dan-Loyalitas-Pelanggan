<!-- Sidebar -->
<div x-data="{ sidebarOpen: window.innerWidth >= 768 }" @toggle-sidebar.window="sidebarOpen = !sidebarOpen"
    class="bg-white shadow-lg transform transition-all duration-300 ease-in-out fixed overflow-hidden"
    :class="{ 'w-0': !sidebarOpen, 'w-64': sidebarOpen, '-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen }"
    style="position: fixed; height: 100%; left: 0; bottom: 0; z-index: 10;">
    <!-- Sidebar Header -->
    <div class="flex items-center justify-between h-16 px-4 bg-gray-50 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-800 text-left">Menu</h2>
        <button @click="sidebarOpen = false" class="md:hidden text-gray-500 hover:text-gray-700 focus:outline-none">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <!-- Navigation Links -->
    <nav class="mt-8 px-4 mx-2">
        <div class="space-y-2">
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                class="block px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-md text-left">
                {{ __('Dashboard') }}
            </x-nav-link>

            <!-- Manajemen Kampanye Survei (UMKM & Superadmin) -->
            @role('umkm|superadmin')
            <div x-data="{ subOpen: {{ request()->routeIs('survey-campaigns.*') ? 'true' : 'false' }} }">
                <button @click="subOpen = !subOpen"
                    class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium {{ request()->routeIs('survey-campaigns.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }} rounded-md focus:outline-none text-left">
                    <span class="flex items-center">
                        <i class="fas fa-poll-h mr-2"></i>
                        {{ __('Manajemen Kampanye Survei') }}
                    </span>
                    <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': subOpen }" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="subOpen" x-transition class="ml-4 mt-1 space-y-1">
                    <x-nav-link :href="route('survey-campaigns.index')"
                        :active="request()->routeIs('survey-campaigns.index')"
                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-md text-left">
                        <i class="fas fa-list-alt mr-2 text-xs"></i>
                        Daftar Kampanye
                    </x-nav-link>
                    <x-nav-link :href="route('survey-campaigns.create')"
                        :active="request()->routeIs('survey-campaigns.create')"
                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-md text-left">
                        <i class="fas fa-plus-circle mr-2 text-xs"></i>
                        Buat Kampanye Baru
                    </x-nav-link>
                </div>
            </div>
            @endrole

            <!-- Manajemen User (Superadmin) -->
            @role('superadmin')
            <x-nav-link :href="route('user-management.index')" :active="request()->routeIs('user-management.*')"
                class="block px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-md text-left">
                {{ __('Manajemen User') }}
            </x-nav-link>
            @endrole
            <!-- Manajemen Survei Kepuasan dan Loyalitas Pelanggan with Submenu -->
            <div x-data="{ subOpen: false }">
                <button @click="subOpen = !subOpen"
                    class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-md focus:outline-none text-left">
                    {{ __('Manajemen Survei Kepuasan dan Loyalitas Pelanggan') }}
                    <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': subOpen }" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="subOpen" x-transition class="ml-4 space-y-1">
                    @role('umkm|superadmin')
                    <x-nav-link :href="route('grafik.select-campaign')"
                        :active="request()->routeIs('grafik.*')"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-md text-left">
                        <i class="fas fa-chart-pie mr-2 text-xs"></i>
                        Analytics
                    </x-nav-link>
                    <x-nav-link :href="route('dashboard.pelatihan')"
                        :active="request()->routeIs('dashboard.pelatihan')"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-md text-left">
                        Pelatihan
                    </x-nav-link>
                    <x-nav-link :href="route('dashboard.produk')"
                        :active="request()->routeIs('dashboard.produk')"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-md text-left">
                        Produk
                    </x-nav-link>

                    @endrole
                </div>
            </div>
            <!-- Manajemen Evaluasi CRM with Submenu -->
            <div x-data="{ subOpen: false }">
                <button @click="subOpen = !subOpen"
                    class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-md focus:outline-none text-left">
                    {{ __('Manajemen Evaluasi CRM') }}
                    <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': subOpen }" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="subOpen" x-transition class="ml-4 space-y-1">
                    <x-nav-link :href="route('dashboard.customer-evaluation-management.index')"
                        :active="request()->routeIs('dashboard.customer-evaluation-management.*')"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-md text-left">
                        Kelola Data Evaluasi
                    </x-nav-link>

                    <x-nav-link :href="route('rfm.show', Auth::user()->umkm_id)"
                        :active="request()->routeIs('rfm.*')"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-md text-left">
                        RFM
                    </x-nav-link>
                </div>
            </div>
        </div>
    </nav>

    <!-- User Section -->
    <div class="absolute bottom-0 left-0 right-0 pb-3 border-t border-gray-200 bg-white">
        <div x-data="{ userMenuOpen: false }" class="px-4 pt-4">
            <button @click="userMenuOpen = !userMenuOpen"
                class="flex items-center justify-between w-full py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-md focus:outline-none text-left">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                            <span
                                class="text-sm font-medium text-gray-700">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                        </div>
                    </div>
                    <div class="ml-3 text-left">
                        <div class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': userMenuOpen }" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div x-show="userMenuOpen" x-transition class="mt-2 space-y-1">
                <a href="{{ route('profile.edit') }}"
                    class="block px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-md text-left">
                    {{ __('Edit Profile') }}
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="block w-full text-left px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-md">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>