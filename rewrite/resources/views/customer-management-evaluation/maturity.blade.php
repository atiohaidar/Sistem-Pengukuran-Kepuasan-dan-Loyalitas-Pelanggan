<x-mylayout>
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <span class="text-sm font-medium text-gray-700">Langkah 1 dari 3</span>
                <span class="text-sm font-medium text-gray-700">33%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-indigo-600 h-2 rounded-full" style="width: 33%"></div>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Asesmen Maturitas</h2>
            <p class="text-gray-600 mb-6">Pada tahap ini, pilih kondisi sistem manajemen pelanggan yang paling sesuai dengan perusahaan anda.</p>

            <form action="{{ route('customer-management-evaluation.store-maturity') }}" method="POST">
                @csrf

                <!-- Company Name (hidden or pre-filled) -->
                <input type="hidden" name="company_name" value="{{ $data['company_name'] ?? '' }}">

                <!-- Maturity Questions -->
                <div class="space-y-6">
                    @php
                        $questions = [
                            'visi' => [
                                'label' => 'Visi',
                                'description' => 'Arah masa depan bisnis berfokus pada pelanggan',
                                'options' => [
                                    1 => 'Tidak memiliki visi terkait pelanggan',
                                    2 => 'Mulai memiliki inisiatif terkait pelanggan namun belum terintegrasi ke visi',
                                    3 => 'Visi berorientasi pelanggan mulai diterapkan di masing-masing fungsi',
                                    4 => 'Visi berorientasi pelanggan diadopsi di seluruh unit bisnis internal',
                                    5 => 'Visi berorientasi pelanggan diadopsi di unit bisnis internal dan eksternal',
                                ]
                            ],
                            'strategi' => [
                                'label' => 'Strategi',
                                'description' => 'Pendekatan strategis untuk manajemen pelanggan',
                                'options' => [
                                    1 => 'Tidak ada strategi SPP',
                                    2 => 'Proyek SPP dimulai tanpa koordinasi dan belum terarah',
                                    3 => 'Ada kesadaran strategis SPP tapi masih antar departemen',
                                    4 => 'SPP dikelola terpusat dengan dukungan antar fungsi',
                                    5 => 'SPP dikembangkan bersama mitra untuk manfaat bersama',
                                ]
                            ],
                            'pengalamanKonsumen' => [
                                'label' => 'Pengalaman Konsumen',
                                'description' => 'Memberikan pengalaman kepada pelanggan yang konsisten',
                                'options' => [
                                    1 => 'Tidak ada konsep dan didesain dengan sendiri',
                                    2 => 'Tidak ada konsep dan didesain dengan sendiri',
                                    3 => 'Fokus pada pengalaman konsumen namun hanya di fungsi tertentu',
                                    4 => 'Fokus pada pengalaman konsumen mulai lintas unit',
                                    5 => 'Pengalaman pelanggan dikelola bersama internal dan eksternal',
                                ]
                            ],
                            'kolaborasiOrganisasi' => [
                                'label' => 'Kolaborasi Organisasi',
                                'description' => 'Kolaborasi lintas fungsi untuk fokus pelanggan',
                                'options' => [
                                    1 => 'Setiap departemen bekerja sendiri dan tidak berfokus pada pelanggan',
                                    2 => 'Ada inisiatif untuk berfokus pada pelanggan tapi terkendala SILO',
                                    3 => 'Budaya organisasi mulai bergeser mendukung kolaborasi',
                                    4 => 'Struktur organisasi dirancang berdasarkan segmen pelanggan',
                                    5 => 'Pihak internal dan eksternal bekerja sama dengan tujuan yang sama',
                                ]
                            ],
                            'proses' => [
                                'label' => 'Proses',
                                'description' => 'Proses bisnis yang mendukung pelanggan',
                                'options' => [
                                    1 => 'Proses belum dirancang untuk kepuasan pelanggan (efisiensi internal)',
                                    2 => 'Proses sudah diperbaiki oleh tiap departemen namun belum menyatu',
                                    3 => 'Proses sudah memperhatikan efisiensi dan nilai di level departemen',
                                    4 => 'Proses berorientasi pelanggan mulai diintegrasikan lintas fungsi',
                                    5 => 'Proses terintegrasi dari awal hingga akhir melibatkan pelanggan & mitra',
                                ]
                            ],
                            'informasi' => [
                                'label' => 'Informasi',
                                'description' => 'Penggunaan data pelanggan',
                                'options' => [
                                    1 => 'Data tersebar, tidak konsisten, dan tidak digunakan',
                                    2 => 'Data digunakan secara lokal di tim, tidak dibagikan',
                                    3 => 'Ada pemanfaatan data dalam unit, mulai terlihat insight',
                                    4 => 'Insight dibagikan ke seluruh organisasi',
                                    5 => 'Data dan insight digunakan oleh mitra dan pihak luar',
                                ]
                            ],
                            'teknologi' => [
                                'label' => 'Teknologi',
                                'description' => 'Pemanfaatan teknologi untuk pelanggan',
                                'options' => [
                                    1 => 'Teknologi SPP sangat terbatas dan tidak mendukung aktivitas bisnis',
                                    2 => 'Alat SPP hanya digunakan untuk aktivitas dasar dan tidak terintegrasi',
                                    3 => 'Teknologi SPP mulai kuat namun hanya di departemen tertentu',
                                    4 => 'Teknologi SPP digunakan lintas departemen dan terintegrasi',
                                    5 => 'Teknologi SPP terintegrasi dengan mitra & pelanggan secara digital',
                                ]
                            ],
                            'matriks' => [
                                'label' => 'Matriks',
                                'description' => 'Pengukuran kinerja terkait pelanggan',
                                'options' => [
                                    1 => 'Tidak ada metode pengukuran hanya fokus ke operasional internal',
                                    2 => 'Matriks hanya untuk efisiensi departemen, bukan untuk pelanggan',
                                    3 => 'Matriks fokus pada produktivitas, bukan kepuasan pelanggan',
                                    4 => 'Matriks mencakup aspek pelanggan dan organisasi secara seimbang',
                                    5 => 'Semua pihak memiliki matriks yang selaras untuk jangka panjang',
                                ]
                            ],
                        ];
                    @endphp

                    @foreach($questions as $key => $question)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                {{ $question['label'] }}
                            </label>
                            <p class="text-sm text-gray-500 mb-3">{{ $question['description'] }}</p>
                            <select name="{{ $key }}" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
                                <option value="">Pilih...</option>
                                @foreach($question['options'] as $value => $text)
                                    <option value="{{ $value }}" {{ ($data['maturity'][$key] ?? 1) == $value ? 'selected' : '' }}>
                                        {{ $value }} - {{ $text }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                </div>

                <!-- Submit Button -->
                <div class="mt-8 flex justify-end">
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Selanjutnya
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</x-mylayout>