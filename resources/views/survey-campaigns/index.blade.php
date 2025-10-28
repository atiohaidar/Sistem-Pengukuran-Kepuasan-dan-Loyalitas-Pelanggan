<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen Survei Kepuasan') }}
            </h2>
            <a href="{{ route('survey-campaigns.create') }}" 
               class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg inline-flex items-center transition">
                <i class="fas fa-plus mr-2"></i>
                Buat Survei Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-indigo-100 rounded-md p-3">
                            <i class="fas fa-poll text-indigo-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Total Kampanye</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-100 rounded-md p-3">
                            <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Aktif</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['active'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-red-100 rounded-md p-3">
                            <i class="fas fa-times-circle text-red-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Selesai</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['closed'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-100 rounded-md p-3">
                            <i class="fas fa-users text-purple-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Total Responden</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_responses'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Filter & Search --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('survey-campaigns.index') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            {{-- Search --}}
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Cari Kampanye</label>
                                <div class="relative">
                                    <input type="text" 
                                           name="search" 
                                           value="{{ request('search') }}" 
                                           placeholder="Cari nama kampanye..."
                                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-search text-gray-400"></i>
                                    </div>
                                </div>
                            </div>

                            {{-- Filter Jenis --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Survei</label>
                                <select name="type" class="w-full border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="all" {{ request('type', 'all') === 'all' ? 'selected' : '' }}>Semua</option>
                                    <option value="produk" {{ request('type') === 'produk' ? 'selected' : '' }}>Produk</option>
                                    <option value="pelatihan" {{ request('type') === 'pelatihan' ? 'selected' : '' }}>Pelatihan</option>
                                </select>
                            </div>

                            {{-- Filter Status --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                <select name="status" class="w-full border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="all" {{ request('status', 'all') === 'all' ? 'selected' : '' }}>Semua</option>
                                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
                                    <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Archived</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition">
                                <i class="fas fa-filter mr-2"></i>Filter
                            </button>
                            <a href="{{ route('survey-campaigns.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition">
                                <i class="fas fa-redo mr-2"></i>Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Campaigns Table --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kampanye
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Jenis
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Periode
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Responden
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($campaigns as $campaign)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-{{ $campaign->getTypeBadgeColor() }}-100 flex items-center justify-center">
                                                <i class="fas {{ $campaign->getTypeIcon() }} text-{{ $campaign->getTypeBadgeColor() }}-600"></i>
                                            </div>
                                            <div class="ml-4">
                                                <a href="{{ route('survey-campaigns.dashboard', $campaign) }}" 
                                                   class="text-sm font-medium text-indigo-600 hover:text-indigo-900">
                                                    {{ $campaign->name }}
                                                </a>
                                                <p class="text-sm text-gray-500">{{ Str::limit($campaign->description, 50) }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $campaign->getTypeBadgeColor() }}-100 text-{{ $campaign->getTypeBadgeColor() }}-800">
                                            {{ ucfirst($campaign->type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $campaign->getStatusBadgeColor() }}-100 text-{{ $campaign->getStatusBadgeColor() }}-800">
                                            <i class="fas 
                                                @if($campaign->status === 'active') fa-check-circle
                                                @elseif($campaign->status === 'closed') fa-times-circle
                                                @elseif($campaign->status === 'draft') fa-edit
                                                @else fa-archive
                                                @endif mr-1"></i>
                                            {{ ucfirst($campaign->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div>
                                            <i class="fas fa-calendar-alt mr-1"></i>
                                            {{ $campaign->start_date->format('d M Y') }}
                                        </div>
                                        <div class="text-xs">
                                            s/d {{ $campaign->end_date->format('d M Y') }}
                                        </div>
                                        @if($campaign->status === 'active')
                                            <div class="text-xs text-indigo-600 mt-1">
                                                <i class="fas fa-clock mr-1"></i>
                                                {{ $campaign->days_remaining }} hari tersisa
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 font-medium">
                                            {{ $campaign->responses_count }}
                                            @if($campaign->max_respondents)
                                                / {{ $campaign->max_respondents }}
                                            @endif
                                        </div>
                                        @if($campaign->max_respondents)
                                            <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                                                <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ $campaign->progress_percentage }}%"></div>
                                            </div>
                                            <div class="text-xs text-gray-500 mt-1">{{ number_format($campaign->progress_percentage, 1) }}%</div>
                                        @else
                                            <div class="text-xs text-gray-500">Unlimited</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center gap-2">
                                            {{-- Dashboard --}}
                                            <a href="{{ route('survey-campaigns.dashboard', $campaign) }}" 
                                               class="text-indigo-600 hover:text-indigo-900" 
                                               title="Dashboard">
                                                <i class="fas fa-chart-bar"></i>
                                            </a>

                                            {{-- Copy Link --}}
                                            <button onclick="copyToClipboard('{{ $campaign->public_url }}')" 
                                                    class="text-green-600 hover:text-green-900" 
                                                    title="Copy Link">
                                                <i class="fas fa-copy"></i>
                                            </button>

                                            {{-- Edit --}}
                                            <a href="{{ route('survey-campaigns.edit', $campaign) }}" 
                                               class="text-yellow-600 hover:text-yellow-900" 
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            {{-- Responses --}}
                                            <a href="{{ route('survey-campaigns.responses', $campaign) }}" 
                                               class="text-blue-600 hover:text-blue-900" 
                                               title="Lihat Responses">
                                                <i class="fas fa-users"></i>
                                            </a>

                                            {{-- Export --}}
                                            <a href="{{ route('survey-campaigns.export', $campaign) }}" 
                                               class="text-purple-600 hover:text-purple-900" 
                                               title="Export">
                                                <i class="fas fa-download"></i>
                                            </a>

                                            {{-- Status Actions --}}
                                            @if($campaign->status === 'draft' || $campaign->status === 'closed')
                                                <form action="{{ route('survey-campaigns.activate', $campaign) }}" 
                                                      method="POST" 
                                                      class="inline">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="text-green-600 hover:text-green-900" 
                                                            title="Aktifkan">
                                                        <i class="fas fa-play-circle"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            @if($campaign->status === 'active')
                                                <form action="{{ route('survey-campaigns.close', $campaign) }}" 
                                                      method="POST" 
                                                      class="inline">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="text-red-600 hover:text-red-900" 
                                                            title="Tutup"
                                                            onclick="return confirm('Yakin ingin menutup survei ini?')">
                                                        <i class="fas fa-stop-circle"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            {{-- Delete --}}
                                            <form action="{{ route('survey-campaigns.destroy', $campaign) }}" 
                                                  method="POST" 
                                                  class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-600 hover:text-red-900" 
                                                        title="Hapus"
                                                        onclick="return confirm('Yakin ingin menghapus kampanye ini? Semua data responses akan terhapus!')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <i class="fas fa-poll text-gray-400 text-5xl mb-4"></i>
                                            <p class="text-gray-500 text-lg mb-2">Belum ada kampanye survei</p>
                                            <p class="text-gray-400 text-sm mb-4">Buat kampanye survei pertama Anda untuk mulai mengumpulkan feedback</p>
                                            <a href="{{ route('survey-campaigns.create') }}" 
                                               class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg inline-flex items-center transition">
                                                <i class="fas fa-plus mr-2"></i>
                                                Buat Survei Baru
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($campaigns->hasPages())
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                        {{ $campaigns->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Toast Notification --}}
    @if(session('success'))
        <div id="toast" class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2 z-50">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div id="toast" class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2 z-50">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @push('scripts')
    <script>
        // Copy to clipboard function
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                // Show toast
                const toast = document.createElement('div');
                toast.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2 z-50';
                toast.innerHTML = '<i class="fas fa-check-circle"></i><span>Link berhasil disalin!</span>';
                document.body.appendChild(toast);
                
                setTimeout(() => {
                    toast.remove();
                }, 3000);
            });
        }

        // Auto hide toast
        const toast = document.getElementById('toast');
        if (toast) {
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transition = 'opacity 0.5s';
                setTimeout(() => toast.remove(), 500);
            }, 3000);
        }
    </script>
    @endpush
</x-app-layout>
