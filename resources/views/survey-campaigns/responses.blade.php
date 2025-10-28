<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Respons Survei') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    {{ $campaign->name }}
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('survey-campaigns.dashboard', $campaign) }}" 
                   class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition">
                    <i class="fas fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('survey-campaigns.export', $campaign) }}" 
                   class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                    <i class="fas fa-download"></i>
                    <span>Export Excel</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Campaign Info Card --}}
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <div class="flex items-start justify-between">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 bg-{{ $campaign->getTypeBadgeColor() }}-100 rounded-lg p-3">
                            <i class="fas {{ $campaign->getTypeIcon() }} text-{{ $campaign->getTypeBadgeColor() }}-600 text-2xl"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <h3 class="text-lg font-bold text-gray-900">{{ $campaign->name }}</h3>
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-{{ $campaign->getStatusBadgeColor() }}-100 text-{{ $campaign->getStatusBadgeColor() }}-800">
                                    {{ ucfirst($campaign->status) }}
                                </span>
                            </div>
                            @if($campaign->description)
                                <p class="text-sm text-gray-600 mb-2">{{ $campaign->description }}</p>
                            @endif
                            <div class="flex items-center gap-4 text-sm text-gray-500">
                                <span><i class="fas fa-calendar mr-1"></i> {{ $campaign->start_date->format('d M Y') }} - {{ $campaign->end_date->format('d M Y') }}</span>
                                <span><i class="fas fa-users mr-1"></i> {{ $responses->total() }} respons</span>
                                @if($campaign->max_respondents)
                                    <span><i class="fas fa-chart-pie mr-1"></i> {{ number_format($campaign->progress_percentage, 1) }}% terisi</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('survey-campaigns.index') }}" 
                       class="text-gray-400 hover:text-gray-600 transition">
                        <i class="fas fa-times text-xl"></i>
                    </a>
                </div>
            </div>

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Respons</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $responses->total() }}</p>
                        </div>
                        <div class="bg-blue-100 rounded-lg p-3">
                            <i class="fas fa-file-alt text-blue-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Hari Ini</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $todayCount }}</p>
                        </div>
                        <div class="bg-green-100 rounded-lg p-3">
                            <i class="fas fa-calendar-day text-green-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Minggu Ini</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $weekCount }}</p>
                        </div>
                        <div class="bg-purple-100 rounded-lg p-3">
                            <i class="fas fa-calendar-week text-purple-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Bulan Ini</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $monthCount }}</p>
                        </div>
                        <div class="bg-orange-100 rounded-lg p-3">
                            <i class="fas fa-calendar-alt text-orange-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Filter & Search --}}
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <form method="GET" action="{{ route('survey-campaigns.responses', $campaign) }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-search mr-1"></i> Cari
                            </label>
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Nama, email, atau nomor HP..."
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-calendar mr-1"></i> Dari Tanggal
                            </label>
                            <input type="date" 
                                   name="start_date" 
                                   value="{{ request('start_date') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-calendar mr-1"></i> Sampai Tanggal
                            </label>
                            <input type="date" 
                                   name="end_date" 
                                   value="{{ request('end_date') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        </div>

                        <div class="flex items-end gap-2">
                            <button type="submit" 
                                    class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition">
                                <i class="fas fa-filter mr-2"></i> Filter
                            </button>
                            <a href="{{ route('survey-campaigns.responses', $campaign) }}" 
                               class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition">
                                <i class="fas fa-redo"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Responses Table --}}
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                @if($responses->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        #
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Responden
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Kontak
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Waktu Submit
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($responses as $index => $response)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $responses->firstItem() + $index }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 bg-indigo-100 rounded-full flex items-center justify-center">
                                                    <span class="text-indigo-600 font-medium text-sm">
                                                        {{ strtoupper(substr($response->nama, 0, 2)) }}
                                                    </span>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $response->nama }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        {{ $response->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                                        @if($response->usia), {{ $response->usia }} tahun @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                <i class="fas fa-envelope text-gray-400 mr-1"></i>
                                                {{ $response->email ?? '-' }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                <i class="fas fa-phone text-gray-400 mr-1"></i>
                                                {{ $response->nomor_hp ?? '-' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $response->created_at->format('d M Y') }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ $response->created_at->format('H:i') }} WIB
                                            </div>
                                            <div class="text-xs text-gray-400">
                                                {{ $response->created_at->diffForHumans() }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                                <i class="fas fa-check-circle mr-1"></i> Selesai
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('survey-campaigns.response-detail', [$campaign, $response]) }}" 
                                               class="inline-flex items-center gap-1 text-indigo-600 hover:text-indigo-900 transition">
                                                <i class="fas fa-eye"></i>
                                                <span>Detail</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $responses->links() }}
                    </div>
                @else
                    {{-- Empty State --}}
                    <div class="text-center py-12">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                            <i class="fas fa-inbox text-gray-400 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Respons</h3>
                        <p class="text-gray-500 mb-6">
                            @if(request()->hasAny(['search', 'start_date', 'end_date']))
                                Tidak ada respons yang sesuai dengan filter Anda.
                            @else
                                Kampanye ini belum memiliki respons dari responden.
                            @endif
                        </p>
                        @if(request()->hasAny(['search', 'start_date', 'end_date']))
                            <a href="{{ route('survey-campaigns.responses', $campaign) }}" 
                               class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 transition">
                                <i class="fas fa-redo"></i>
                                <span>Reset Filter</span>
                            </a>
                        @else
                            <div class="space-y-3">
                                <div>
                                    <button onclick="copyLink('{{ $campaign->public_url }}')" 
                                            class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg transition">
                                        <i class="fas fa-copy"></i>
                                        <span>Copy Link Survei</span>
                                    </button>
                                </div>
                                <p class="text-sm text-gray-500">
                                    Bagikan link survei untuk mulai menerima respons
                                </p>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Toast Notification --}}
    <div id="toast" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg hidden items-center gap-2 z-50">
        <i class="fas fa-check-circle"></i>
        <span id="toastMessage">Link berhasil disalin!</span>
    </div>

    @push('scripts')
    <script>
        function copyLink(url) {
            navigator.clipboard.writeText(url).then(() => {
                showToast('Link survei berhasil disalin!');
            });
        }

        function showToast(message) {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toastMessage');
            toastMessage.textContent = message;
            toast.classList.remove('hidden');
            toast.classList.add('flex');
            
            setTimeout(() => {
                toast.classList.add('hidden');
                toast.classList.remove('flex');
            }, 3000);
        }
    </script>
    @endpush
</x-app-layout>
