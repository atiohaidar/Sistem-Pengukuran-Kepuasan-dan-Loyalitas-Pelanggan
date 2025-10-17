<!-- Sidebar -->
<div x-data="{ sidebarOpen: window.innerWidth >= 768 }" @toggle-sidebar.window="sidebarOpen = !sidebarOpen" class="bg-white shadow-lg transform transition-all duration-300 ease-in-out relative overflow-hidden"
     :class="{ 'w-0': !sidebarOpen, 'w-64': sidebarOpen, '-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen }">

    <!-- Sidebar Header -->
    <div class="flex items-center justify-between h-16 px-4 bg-gray-50 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-800">Menu</h2>
        <!-- Close Button for Desktop -->
        <button @click="sidebarOpen = false" class="md:hidden text-gray-500 hover:text-gray-700 focus:outline-none">
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
            <x-nav-link :href="route('dashboard.survey-management.index')" :active="request()->routeIs('dashboard.survey-management.*')" class="block px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-md">
                {{ __('Manajemen Survei') }}
            </x-nav-link>
            <x-nav-link :href="route('dashboard.customer-evaluation-management.index')" :active="request()->routeIs('dashboard.customer-evaluation-management.*')" class="block px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-md">
                {{ __('Manajemen Evaluasi') }}
            </x-nav-link>
        </div>
    </nav>
</div>
