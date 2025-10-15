<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Evaluasi - ') . $evaluation->company_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('dashboard.customer-evaluation-management.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Daftar Evaluasi
                </a>
            </div>

            <!-- Company Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="px-6 py-4 bg-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Informasi Perusahaan</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">ID Evaluasi</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $evaluation->id }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Token</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <code class="px-2 py-1 bg-gray-100 rounded text-xs">{{ $evaluation->token }}</code>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Nama Perusahaan</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $evaluation->company_name }}</dd>
                                </div>
                            </dl>
                        </div>
                        <div>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                                    <dd class="mt-1">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $evaluation->completed ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ $evaluation->completed ? 'Selesai' : 'Belum Selesai' }}
                                        </span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Dibuat</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $evaluation->created_at->format('d/m/Y H:i:s') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Terakhir Diupdate</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $evaluation->updated_at->format('d/m/Y H:i:s') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Maturity Assessment -->
            @if($evaluation->maturity_data)
                <div class="bg-gray-50 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="px-6 py-4 bg-gray-100 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Asesmen Maturitas</h3>
                    </div>
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Komponen</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($questionLabels['maturity'] as $key => $label)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $label }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                @if(isset($evaluation->maturity_data[$key]))
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                        @if($evaluation->maturity_data[$key] == 1) bg-red-100 text-red-800
                                                        @elseif($evaluation->maturity_data[$key] == 2) bg-orange-100 text-orange-800
                                                        @elseif($evaluation->maturity_data[$key] == 3) bg-yellow-100 text-yellow-800
                                                        @elseif($evaluation->maturity_data[$key] == 4) bg-green-100 text-green-800
                                                        @elseif($evaluation->maturity_data[$key] == 5) bg-blue-100 text-blue-800
                                                        @endif">
                                                        {{ $evaluation->maturity_data[$key] }}/5
                                                    </span>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                @php
                                                    $maturityDescriptions = [
                                                        1 => 'Tidak ada atau sangat terbatas',
                                                        2 => 'Ada inisiatif awal namun belum terintegrasi',
                                                        3 => 'Sudah diterapkan di beberapa area',
                                                        4 => 'Sudah terintegrasi di seluruh organisasi',
                                                        5 => 'Sangat matang dan menjadi keunggulan kompetitif'
                                                    ];
                                                @endphp
                                                {{ $maturityDescriptions[$evaluation->maturity_data[$key]] ?? '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Priority Assessment -->
            @if($evaluation->priority_data)
                <div class="bg-gray-50 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="px-6 py-4 bg-gray-100 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Prioritas Implementasi (%)</h3>
                    </div>
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Area Fokus</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Persentase Prioritas</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tingkat Prioritas</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($questionLabels['priority'] as $key => $label)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $label }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                @if(isset($evaluation->priority_data[$key]))
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        {{ number_format($evaluation->priority_data[$key], 1) }}%
                                                    </span>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                @if(isset($evaluation->priority_data[$key]))
                                                    @php
                                                        $percentage = $evaluation->priority_data[$key];
                                                        if ($percentage >= 80) {
                                                            $priorityLevel = 'Sangat Tinggi';
                                                            $colorClass = 'bg-red-100 text-red-800';
                                                        } elseif ($percentage >= 60) {
                                                            $priorityLevel = 'Tinggi';
                                                            $colorClass = 'bg-orange-100 text-orange-800';
                                                        } elseif ($percentage >= 40) {
                                                            $priorityLevel = 'Sedang';
                                                            $colorClass = 'bg-yellow-100 text-yellow-800';
                                                        } elseif ($percentage >= 20) {
                                                            $priorityLevel = 'Rendah';
                                                            $colorClass = 'bg-green-100 text-green-800';
                                                        } else {
                                                            $priorityLevel = 'Sangat Rendah';
                                                            $colorClass = 'bg-blue-100 text-blue-800';
                                                        }
                                                    @endphp
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $colorClass }}">
                                                        {{ $priorityLevel }}
                                                    </span>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Readiness Assessment -->
            @if($evaluation->readiness_data)
                <div class="bg-gray-50 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="px-6 py-4 bg-gray-100 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Tingkat Kesiapan Organisasi</h3>
                    </div>
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aspek Kesiapan</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tingkat Kesiapan</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($questionLabels['readiness'] as $key => $label)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $label }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                @if(isset($evaluation->readiness_data[$key]))
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                        @if($evaluation->readiness_data[$key] == 1) bg-red-100 text-red-800
                                                        @elseif($evaluation->readiness_data[$key] == 2) bg-orange-100 text-orange-800
                                                        @elseif($evaluation->readiness_data[$key] == 3) bg-yellow-100 text-yellow-800
                                                        @elseif($evaluation->readiness_data[$key] == 4) bg-green-100 text-green-800
                                                        @elseif($evaluation->readiness_data[$key] == 5) bg-blue-100 text-blue-800
                                                        @endif">
                                                        {{ $evaluation->readiness_data[$key] }}/5
                                                    </span>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                @php
                                                    $readinessDescriptions = [
                                                        1 => 'Sangat tidak siap - Perlu banyak persiapan',
                                                        2 => 'Tidak siap - Perlu persiapan signifikan',
                                                        3 => 'Cukup siap - Perlu beberapa persiapan',
                                                        4 => 'Siap - Hanya perlu sedikit penyesuaian',
                                                        5 => 'Sangat siap - Siap untuk implementasi'
                                                    ];
                                                @endphp
                                                {{ $readinessDescriptions[$evaluation->readiness_data[$key]] ?? '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            <!-- No Data Message -->
            @if(!$evaluation->maturity_data && !$evaluation->priority_data && !$evaluation->readiness_data)
                <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">Tidak ada data evaluasi</h3>
                            <div class="mt-2 text-sm text-yellow-700">
                                <p>Evaluasi ini belum diisi lengkap atau data belum tersimpan dengan benar.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>