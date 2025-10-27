<x-app-layout title="Manajemen User">
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
        <!-- Header -->
        <div class="bg-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-6">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Manajemen User</h1>
                    </div>

                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <!-- Total Users -->
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Pengguna</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $users->total() }}</p>
                            <p class="text-sm text-green-600 mt-1">
                                <i class="fas fa-users mr-1"></i>
                                Terdaftar
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-blue-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Approved Users -->
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Disetujui</p>
                            <p class="text-3xl font-bold text-gray-900">
                                {{ $users->where('status', 'approved')->count() }}
                            </p>
                            <p class="text-sm text-green-600 mt-1">
                                <i class="fas fa-check-circle mr-1"></i>
                                Aktif
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Pending Users -->
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-yellow-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Pending</p>
                            <p class="text-3xl font-bold text-gray-900">
                                {{ $users->where('status', 'pending')->count() }}
                            </p>
                            <p class="text-sm text-yellow-600 mt-1">
                                <i class="fas fa-clock mr-1"></i>
                                Menunggu
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clock text-yellow-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Rejected Users -->
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-red-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Ditolak</p>
                            <p class="text-3xl font-bold text-gray-900">
                                {{ $users->where('status', 'rejected')->count() }}
                            </p>
                            <p class="text-sm text-red-600 mt-1">
                                <i class="fas fa-times-circle mr-1"></i>
                                Tidak Aktif
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-times-circle text-red-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters and Table -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                <div
                    class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0 mb-6">
                    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4">
                        <form method="GET" action="{{ route('user-management.index') }}" class="flex space-x-2">
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama atau email..."
                                class="block w-full sm:w-80 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <select name="status"
                                class="block px-3 py-2 border border-gray-300 rounded-md shadow-sm sm:text-sm">
                                <option value="all">Semua Status</option>
                                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>
                                    Disetujui</option>
                                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak
                                </option>
                            </select>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                Cari
                            </button>
                        </form>
                    </div>

                    <a href="#"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Export CSV
                    </a>
                </div>

                <div class="overflow-x-auto max-h-[60vh] overflow-y-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nama</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                                    Email</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                    UMKM</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">
                                    Kategori UMKM</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                    Peran</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($users as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center mr-3">
                                                <i class="fas fa-user text-indigo-600"></i>
                                            </div>
                                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 hidden sm:table-cell">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 hidden md:table-cell">
                                        {{ optional($user->umkm)->nama_usaha ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 hidden lg:table-cell">
                                        {{ optional($user->umkm)->kategori_usaha ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 hidden md:table-cell">
                                        {{ ucfirst($user->role ?? 'user') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($user->status === 'approved')
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Disetujui</span>
                                        @elseif($user->status === 'rejected')
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Ditolak</span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex flex-wrap items-center gap-2 justify-start">
                                            @if($user->status === 'pending')
                                                <form method="POST"
                                                    action="{{ route('user-management.change-status', $user->id) }}"
                                                    class="inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="approved">
                                                    <button type="submit" onclick="return confirm('Setujui pengguna ini?')"
                                                        class="px-3 py-1 bg-green-600 text-white rounded-md text-sm"
                                                        title="Setujui"><i class="fas fa-check"></i></button>
                                                </form>

                                                <form method="POST"
                                                    action="{{ route('user-management.change-status', $user->id) }}"
                                                    class="inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="rejected">
                                                    <button type="submit" onclick="return confirm('Tolak pengguna ini?')"
                                                        class="px-3 py-1 bg-red-600 text-white rounded-md text-sm"
                                                        title="Tolak"><i class="fas fa-times"></i></button>
                                                </form>
                                            @endif

                                            <a href="{{ route('user-management.show', $user) }}"
                                                class="text-indigo-600 hover:text-indigo-900">Detail</a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center py-8">
                                            <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                </path>
                                            </svg>
                                            <p class="text-gray-500 text-sm">Tidak ada pengguna.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($users->hasPages())
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                        {{ $users->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>