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

    <div class="py-12 bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('survey-campaigns.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 border border-blue-500 rounded-lg shadow-sm text-sm font-medium text-white hover:from-blue-600 hover:to-blue-700 hover:border-blue-600 transition-all duration-200 transform hover:scale-105">
                    <i class="fas fa-arrow-left mr-2 text-lg"></i>
                    <span class="font-semibold">Kembali ke Daftar Campaign</span>
                </a>
            </div>

            {{-- Campaign Info Card --}}
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl border-0 relative animate-fade-in mb-6">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 rounded-2xl opacity-10"></div>
                <div class="relative bg-white sm:rounded-2xl p-6">
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
                                    <span><i class="fas fa-users mr-1"></i> {{ $surveyResponses->total() }} respons</span>
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

            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl border-0 relative animate-fade-in">
                <!-- Gradient border effect -->
                <div class="absolute inset-0 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 rounded-2xl opacity-10">
                </div>

                <div class="relative bg-white sm:rounded-2xl p-8">
                    <!-- Header with Export Button -->
                    <div class="flex justify-between items-center mb-8">
                        <div class="flex items-center">
                            <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-3 rounded-full mr-4 shadow-lg">
                                <i class="fas fa-database text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                    Manajemen Data Respons {{ ucfirst($type) }}</h3>
                                <p class="mt-1 text-sm text-gray-600">
                                    Kelola data respons campaign |
                                    <a href="{{ route('survey-campaigns.dashboard', $campaign) }}"
                                        class="text-blue-600 hover:text-blue-800 font-medium transition-colors duration-200">
                                        <i class="fas fa-chart-line mr-1"></i>Dashboard Campaign →
                                    </a>
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('survey-campaigns.export', $campaign) }}"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:from-green-600 hover:to-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            <span>Export Excel</span>
                        </a>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl border-0 relative animate-fade-in">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl opacity-10"></div>
                            <div class="relative bg-white sm:rounded-2xl p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-3 rounded-full mr-4 shadow-lg">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 truncate">Total Responden</dt>
                                            <dd class="text-3xl font-bold text-gray-900">{{ $stats['total_responses'] }}</dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl border-0 relative animate-fade-in">
                            <div class="absolute inset-0 bg-gradient-to-r from-green-500 to-green-600 rounded-2xl opacity-10"></div>
                            <div class="relative bg-white sm:rounded-2xl p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="bg-gradient-to-r from-green-500 to-green-600 p-3 rounded-full mr-4 shadow-lg">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 truncate">Survei Selesai</dt>
                                            <dd class="text-3xl font-bold text-gray-900">{{ $stats['completed_responses'] }}</dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl border-0 relative animate-fade-in">
                            <div class="absolute inset-0 bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-2xl opacity-10"></div>
                            <div class="relative bg-white sm:rounded-2xl p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 p-3 rounded-full mr-4 shadow-lg">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 truncate">Survei Draft</dt>
                                            <dd class="text-3xl font-bold text-gray-900">{{ $stats['draft_responses'] }}</dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl border-0 relative animate-fade-in">
                            <div class="absolute inset-0 bg-gradient-to-r from-purple-500 to-purple-600 rounded-2xl opacity-10"></div>
                            <div class="relative bg-white sm:rounded-2xl p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-3 rounded-full mr-4 shadow-lg">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 truncate">Sesi Unik</dt>
                                            <dd class="text-3xl font-bold text-gray-900">{{ $stats['unique_sessions'] }}</dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Survey Responses Table -->
                    <div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl border-0 relative animate-fade-in">
                        <div class="absolute inset-0 bg-gradient-to-r from-gray-500 via-slate-500 to-gray-500 rounded-2xl opacity-5"></div>
                        <div class="relative bg-white sm:rounded-2xl overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gradient-to-r from-gray-50 to-slate-100">
                                        <tr>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                <span class="flex items-center">
                                                    <i class="fas fa-hashtag mr-2 text-gray-500"></i>
                                                    ID
                                                </span>
                                            </th>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                <span class="flex items-center">
                                                    <i class="fas fa-envelope mr-2 text-gray-500"></i>
                                                    Email
                                                </span>
                                            </th>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                <span class="flex items-center">
                                                    <i class="fas fa-venus-mars mr-2 text-gray-500"></i>
                                                    Jenis Kelamin
                                                </span>
                                            </th>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                <span class="flex items-center">
                                                    <i class="fas fa-birthday-cake mr-2 text-gray-500"></i>
                                                    Usia
                                                </span>
                                            </th>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                <span class="flex items-center">
                                                    <i class="fas fa-briefcase mr-2 text-gray-500"></i>
                                                    Pekerjaan
                                                </span>
                                            </th>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                <span class="flex items-center">
                                                    <i class="fas fa-map-marker-alt mr-2 text-gray-500"></i>
                                                    Domisili
                                                </span>
                                            </th>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                <span class="flex items-center">
                                                    <i class="fas fa-info-circle mr-2 text-gray-500"></i>
                                                    Status
                                                </span>
                                            </th>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                <span class="flex items-center">
                                                    <i class="fas fa-calendar mr-2 text-gray-500"></i>
                                                    Dibuat
                                                </span>
                                            </th>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                <span class="flex items-center">
                                                    <i class="fas fa-cogs mr-2 text-gray-500"></i>
                                                    Aksi
                                                </span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse($surveyResponses as $response)
                                            <tr class="hover:bg-gray-50 hover:transform hover:translate-y-[-1px] transition-all duration-200">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $response->id }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $response->profile_data['email'] ?? '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    @if($response->profile_data['jenis_kelamin'] ?? null)
                                                        @if($response->profile_data['jenis_kelamin'] === 'L')
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Laki-laki</span>
                                                        @else
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-pink-100 text-pink-800">Perempuan</span>
                                                        @endif
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $response->profile_data['usia'] ?? '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $response->profile_data['pekerjaan'] ?? '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $response->profile_data['domisili'] ?? '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if($response->status === 'completed')
                                                        <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Selesai</span>
                                                    @else
                                                        <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">Draft</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $response->created_at->format('d/m/Y H:i') }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <a href="{{ route('survey-campaigns.response-detail', [$campaign, $response]) }}"
                                                       class="inline-flex items-center gap-1 text-indigo-600 hover:text-indigo-900 transition">
                                                        <i class="fas fa-eye"></i>
                                                        <span>Detail</span>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="px-6 py-8 text-center text-gray-500">
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
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    @if($surveyResponses->hasPages())
                        <div class="mt-8 bg-white overflow-hidden shadow-2xl sm:rounded-2xl border-0 relative animate-fade-in">
                            <div class="absolute inset-0 bg-gradient-to-r from-gray-500 via-slate-500 to-gray-500 rounded-2xl opacity-5"></div>
                            <div class="relative bg-white sm:rounded-2xl p-6">
                                {{ $surveyResponses->links() }}
                            </div>
                        </div>
                    @endif
                </div>
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

<style>
    /* Custom animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fadeInUp 0.6s ease-out;
    }

    /* Hover effects for table rows */
    tr:hover {
        transform: translateY(-1px);
        transition: all 0.2s ease;
    }

    /* Button hover effects */
    .btn-hover-scale:hover {
        transform: scale(1.05);
        transition: transform 0.2s ease;
    }

    /* Card hover effects */
    .card-hover:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        transition: all 0.3s ease;
    }
</style>
