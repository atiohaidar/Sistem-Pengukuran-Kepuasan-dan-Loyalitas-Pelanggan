@extends('layouts.user')

@section('content')
<div class="spp-landing">
    <div class="overlay"></div>
    <div class="hero-content">
        <div class="hero-text">
            <h1>Evaluasi Sistem Pengelolaan Pelanggan</h1>
            <p>Alat bantu untuk UMKM dalam menilai sistem pengelolaan pelanggan secara objektif.</p>
        </div>
        <div class="hero-form">
            <div class="card shadow-lg border-0">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex align-items-center mb-3">
                        <div class="hero-icon mr-3">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                        <div>
                            <h3 class="mb-0">Mulai Asesmen</h3>
                            <span class="text-muted small">Lengkapi 3 langkah sederhana untuk melihat hasilnya</span>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h5><i class="fas fa-exclamation-triangle"></i> Mohon periksa kembali</h5>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('spp.survey.submit') }}" method="POST" id="sppForm">
                        @csrf

                        <div class="step-indicator mb-4">
                            <div class="step-item active">
                                <span class="step-number">1</span>
                                <small>Informasi Perusahaan</small>
                            </div>
                            <div class="step-item" id="indicatorStep2">
                                <span class="step-number">2</span>
                                <small>Prioritas</small>
                            </div>
                            <div class="step-item" id="indicatorStep3">
                                <span class="step-number">3</span>
                                <small>Audit</small>
                            </div>
                        </div>

                        <!-- Step 1: Company Info & Maturity Assessment -->
                        <div class="step-content" id="step1">
                            <h4 class="mb-3 font-weight-bold">Informasi Perusahaan & Maturity Assessment</h4>
                            <p class="text-muted mb-4">Mulailah dengan menjelaskan kondisi perusahaan Anda saat ini dan nilai tingkat kematangan manajemen pelanggan.</p>

                            <div class="form-group">
                                <label for="company_name" class="font-weight-bold">Nama Perusahaan <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control form-control-lg rounded-pill @error('company_name') is-invalid @enderror"
                                       id="company_name"
                                       name="company_name"
                                       placeholder="Contoh: PT Maju Jaya" 
                                       value="{{ old('company_name') }}"
                                       required>
                                @error('company_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <hr class="my-4">

                            <h5 class="mb-3 font-weight-bold">Maturity Assessment</h5>
                            <p class="text-muted">Berikan penilaian sesuai dengan kondisi organisasi Anda saat ini.</p>

                            @php
                                $maturityQuestions = [
                                    [
                                        'id' => 'visi',
                                        'label' => 'Visi',
                                        'description' => 'Arah masa depan bisnis berfokus pada pelanggan',
                                        'options' => [
                                            1 => 'Tidak memiliki visi terkait pelanggan',
                                            2 => 'Mulai memiliki inisiatif terkait pelanggan namun belum terintegrasi ke visi',
                                            3 => 'Visi berorientasi pelanggan mulai diterapkan di masing-masing fungsi',
                                            4 => 'Visi berorientasi pelanggan diadopsi di seluruh unit bisnis internal',
                                            5 => 'Visi berorientasi pelanggan diadopsi di unit bisnis internal dan eksternal'
                                        ]
                                    ],
                                    [
                                        'id' => 'strategi',
                                        'label' => 'Strategi',
                                        'description' => 'Pendekatan strategis untuk manajemen pelanggan',
                                        'options' => [
                                            1 => 'Tidak ada strategi SPP',
                                            2 => 'Proyek SPP dimulai tanpa koordinasi dan belum terarah',
                                            3 => 'Ada kesadaran strategis SPP tapi masih antar departemen',
                                            4 => 'SPP dikelola terpusat dengan dukungan antar fungsi',
                                            5 => 'SPP dikembangkan bersama mitra untuk manfaat bersama'
                                        ]
                                    ],
                                    [
                                        'id' => 'pengalamanKonsumen',
                                        'label' => 'Pengalaman Konsumen',
                                        'description' => 'Memberikan pengalaman kepada pelanggan yang konsisten',
                                        'options' => [
                                            1 => 'Tidak ada konsep dan didesain dengan sendiri',
                                            2 => 'Ada upaya perbaikan namun tidak terkoordinasi',
                                            3 => 'Fokus pada pengalaman konsumen namun hanya di fungsi tertentu',
                                            4 => 'Fokus pada pengalaman konsumen mulai lintas unit',
                                            5 => 'Pengalaman pelanggan dikelola bersama internal dan eksternal'
                                        ]
                                    ],
                                    [
                                        'id' => 'kolaborasiOrganisasi',
                                        'label' => 'Kolaborasi Organisasi',
                                        'description' => 'Kolaborasi lintas fungsi untuk fokus pelanggan',
                                        'options' => [
                                            1 => 'Setiap departemen bekerja sendiri dan tidak berfokus pada pelanggan',
                                            2 => 'Ada inisiatif untuk berfokus pada pelanggan tapi terkendala SILO',
                                            3 => 'Budaya organisasi mulai bergeser mendukung kolaborasi',
                                            4 => 'Struktur organisasi dirancang berdasarkan segmen pelanggan',
                                            5 => 'Pihak internal dan eksternal bekerja sama dengan tujuan yang sama'
                                        ]
                                    ],
                                    [
                                        'id' => 'proses',
                                        'label' => 'Proses',
                                        'description' => 'Proses bisnis yang mendukung pelanggan',
                                        'options' => [
                                            1 => 'Proses belum dirancang untuk kepuasan pelanggan (efisiensi internal)',
                                            2 => 'Proses sudah diperbaiki oleh tiap departemen namun belum menyatu',
                                            3 => 'Proses sudah memperhatikan efisiensi dan nilai di level departemen',
                                            4 => 'Proses berorientasi pelanggan mulai diintegrasikan lintas fungsi',
                                            5 => 'Proses terintegrasi dari awal hingga akhir melibatkan pelanggan & mitra'
                                        ]
                                    ],
                                    [
                                        'id' => 'informasi',
                                        'label' => 'Informasi',
                                        'description' => 'Penggunaan data pelanggan',
                                        'options' => [
                                            1 => 'Data tersebar, tidak konsisten, dan tidak digunakan',
                                            2 => 'Data digunakan secara lokal di tim, tidak dibagikan',
                                            3 => 'Ada pemanfaatan data dalam unit, mulai terlihat insight',
                                            4 => 'Insight dibagikan ke seluruh organisasi',
                                            5 => 'Data dan insight digunakan oleh mitra dan pihak luar'
                                        ]
                                    ],
                                    [
                                        'id' => 'teknologi',
                                        'label' => 'Teknologi',
                                        'description' => 'Pemanfaatan teknologi untuk pelanggan',
                                        'options' => [
                                            1 => 'Teknologi SPP sangat terbatas dan tidak mendukung aktivitas bisnis',
                                            2 => 'Alat SPP hanya digunakan untuk aktivitas dasar dan tidak terintegrasi',
                                            3 => 'Teknologi SPP mulai kuat namun hanya di departemen tertentu',
                                            4 => 'Teknologi SPP digunakan lintas departemen dan terintegrasi',
                                            5 => 'Teknologi SPP terintegrasi dengan mitra & pelanggan secara digital'
                                        ]
                                    ],
                                    [
                                        'id' => 'matriks',
                                        'label' => 'Matriks',
                                        'description' => 'Pengukuran kinerja terkait pelanggan',
                                        'options' => [
                                            1 => 'Tidak ada metode pengukuran hanya fokus ke operasional internal',
                                            2 => 'Matriks hanya untuk efisiensi departemen, bukan untuk pelanggan',
                                            3 => 'Matriks fokus pada produktivitas, bukan kepuasan pelanggan',
                                            4 => 'Matriks mencakup aspek pelanggan dan organisasi secara seimbang',
                                            5 => 'Semua pihak memiliki matriks yang selaras untuk jangka panjang'
                                        ]
                                    ]
                                ];
                            @endphp

                            @foreach($maturityQuestions as $index => $question)
                            <div class="form-group mb-4">
                                <label class="font-weight-bold">{{ $index + 1 }}. {{ $question['label'] }} <span class="text-danger">*</span></label>
                                <p class="text-muted small mb-2">{{ $question['description'] }}</p>
                                
                                @foreach($question['options'] as $value => $text)
                                <div class="custom-control custom-radio mb-2">
                                    <input type="radio" 
                                           id="maturity_{{ $index + 1 }}_{{ $value }}" 
                                           name="maturity[{{ $question['id'] }}]" 
                                           class="custom-control-input" 
                                           value="{{ $value }}" 
                                           {{ old('maturity.' . $question['id']) == $value ? 'checked' : '' }}
                                           required>
                                    <label class="custom-control-label" for="maturity_{{ $index + 1 }}_{{ $value }}">
                                        <span class="badge badge-secondary mr-2">{{ $value }}</span> {{ $text }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            @endforeach

                            <button type="button" class="btn btn-primary btn-lg float-right" onclick="nextStep(2)">
                                Selanjutnya <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>

                        <!-- Step 2: Priority Assessment -->
                        <div class="step-content" id="step2" style="display:none;">
                            <h4 class="mb-3 font-weight-bold">Priority Assessment</h4>
                            <p class="text-muted">Alokasikan prioritas untuk setiap item. Total harus 100% dengan kelipatan 5%.</p>

                            <div class="alert alert-info">
                                <strong>Total Saat Ini: <span id="totalPriority">0</span>%</strong>
                                <span id="priorityWarning" class="text-danger ml-2" style="display:none;">
                                    <i class="fas fa-exclamation-triangle"></i> Total harus 100%!
                                </span>
                                   <div id="priorityTotalError" class="text-danger small mt-2" style="display:none;"></div>
                            </div>

                            @php
                                $priorityItems = [
                                    [
                                        'id' => 'kepemimpinanStrategis',
                                        'label' => 'Kepemimpinan Strategis',
                                        'description' => 'Tingkat komitmen dan keterlibatan manajemen puncak.'
                                    ],
                                    [
                                        'id' => 'posisiKompetitif',
                                        'label' => 'Posisi Kompetitif',
                                        'description' => 'Posisi perusahaan jika dibandingkan dengan perusahaan lainnya.'
                                    ],
                                    [
                                        'id' => 'kepuasanPelanggan',
                                        'label' => 'Kepuasan pelanggan',
                                        'description' => 'Kemampuan organisasi dalam memahami, mengukur, dan meningkatkan kepuasan pelanggan.'
                                    ],
                                    [
                                        'id' => 'nilaiUmurPelanggan',
                                        'label' => 'Nilai umur pelanggan',
                                        'description' => 'Kemampuan organisasi dalam memahami nilai jangka panjang pelanggan.'
                                    ],
                                    [
                                        'id' => 'efisiensiBiaya',
                                        'label' => 'Efisiensi Biaya',
                                        'description' => 'Penggunaan biaya dalam melayani pelanggan secara efisien.'
                                    ],
                                    [
                                        'id' => 'aksesPelanggan',
                                        'label' => 'Akses pelanggan',
                                        'description' => 'Efektivitas dan integrasi kanal yang digunakan pelanggan.'
                                    ],
                                    [
                                        'id' => 'solusiAplikasiPelanggan',
                                        'label' => 'Solusi dan aplikasi pelanggan',
                                        'description' => 'Evaluasi terhadap solusi dan aplikasi yang digunakan pelanggan.'
                                    ],
                                    [
                                        'id' => 'informasiPelanggan',
                                        'label' => 'Informasi Pelanggan',
                                        'description' => 'Kualitas, integritas, dan penggunaan informasi pelanggan.'
                                    ],
                                    [
                                        'id' => 'prosesPelanggan',
                                        'label' => 'Proses Pelanggan',
                                        'description' => 'Efisiensi dan efektivitas proses internal yang mendukung pelanggan.'
                                    ],
                                    [
                                        'id' => 'standarSDM',
                                        'label' => 'Standar SDM',
                                        'description' => 'Standar kompetensi dan motivasi karyawan dalam memberikan layanan.'
                                    ],
                                    [
                                        'id' => 'pelaporanKinerja',
                                        'label' => 'Pelaporan Kinerja',
                                        'description' => 'Ketersediaan sistem pengukuran kinerja SPP secara menyeluruh.'
                                    ]
                                ];
                            @endphp

                            @foreach($priorityItems as $index => $item)
                            <div class="form-group row mb-3">
                                <label class="col-sm-7 col-form-label">
                                    <strong>{{ $index + 1 }}. {{ $item['label'] }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $item['description'] }}</small>
                                </label>
                                <div class="col-sm-5">
                                    <div class="input-group">
                                        <input type="number" 
                                               class="form-control priority-input" 
                                               name="priority[{{ $item['id'] }}]" 
                                               value="{{ old('priority.' . $item['id'], 0) }}" 
                                               min="0" 
                                               max="100" 
                                               step="5" 
                                               required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" onclick="prevStep(1)">
                                    <i class="fas fa-arrow-left"></i> Sebelumnya
                                </button>
                                <button type="button" class="btn btn-primary rounded-pill px-4" onclick="nextStep(3)">
                                    Selanjutnya <i class="fas fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 3: Readiness Audit -->
                        <div class="step-content" id="step3" style="display:none;">
                            <h4 class="mb-3 font-weight-bold">Audit Sistem Pengelolaan Pelanggan</h4>
                            <p class="text-muted">Pada tahap ini, pilih kondisi sistem manajemen pelanggan yang paling sesuai dengan perusahaan anda.</p>

                            @php
                                $readinessQuestions = [
                                    [
                                        'id' => 'q1',
                                        'target' => 'kepemimpinanStrategis',
                                        'label' => 'Apakah organisasi saya menunjukkan kepemimpinan dalam proses menjalankan SPP?',
                                        'options' => [
                                            ['value' => 1, 'text' => 'Sangat Tidak Setuju'],
                                            ['value' => 2, 'text' => 'Tidak Setuju'],
                                            ['value' => 3, 'text' => 'Netral'],
                                            ['value' => 4, 'text' => 'Setuju'],
                                            ['value' => 5, 'text' => 'Sangat Setuju']
                                        ]
                                    ],
                                    [
                                        'id' => 'q2',
                                        'target' => 'posisiKompetitif',
                                        'label' => 'Bagaimana posisi perusahaan saya jika dibandingkan dengan perusahaan lainnya?',
                                        'options' => [
                                            ['value' => 1, 'text' => 'Jauh Lebih Buruk'],
                                            ['value' => 2, 'text' => 'Lebih Buruk'],
                                            ['value' => 3, 'text' => 'Setara'],
                                            ['value' => 4, 'text' => 'Lebih Baik'],
                                            ['value' => 5, 'text' => 'Jauh Lebih Baik']
                                        ]
                                    ],
                                    [
                                        'id' => 'q3',
                                        'target' => 'kepuasanPelanggan',
                                        'label' => 'Seberapa puas pelanggan saya terhadap produk dan layanan yang ditawarkan?',
                                        'options' => [
                                            ['value' => 1, 'text' => 'Sangat Tidak Puas'],
                                            ['value' => 2, 'text' => 'Tidak Puas'],
                                            ['value' => 3, 'text' => 'Netral'],
                                            ['value' => 4, 'text' => 'Puas'],
                                            ['value' => 5, 'text' => 'Sangat Puas']
                                        ]
                                    ],
                                    [
                                        'id' => 'q4',
                                        'target' => 'nilaiUmurPelanggan',
                                        'label' => 'Berapa nilai jangka panjang pelanggan saya?',
                                        'options' => [
                                            ['value' => 1, 'text' => 'Sangat Rendah'],
                                            ['value' => 2, 'text' => 'Rendah'],
                                            ['value' => 3, 'text' => 'Sedang'],
                                            ['value' => 4, 'text' => 'Tinggi'],
                                            ['value' => 5, 'text' => 'Sangat Tinggi']
                                        ]
                                    ],
                                    [
                                        'id' => 'q5',
                                        'target' => 'efisiensiBiaya',
                                        'label' => 'Apakah saya sudah menggunakan biaya melayani pelanggan secara efisien?',
                                        'options' => [
                                            ['value' => 1, 'text' => 'Sangat Tidak Efisien'],
                                            ['value' => 2, 'text' => 'Tidak Efisien'],
                                            ['value' => 3, 'text' => 'Netral'],
                                            ['value' => 4, 'text' => 'Efisien'],
                                            ['value' => 5, 'text' => 'Sangat Efisien']
                                        ]
                                    ],
                                    [
                                        'id' => 'q6',
                                        'target' => 'aksesPelanggan',
                                        'label' => 'Seberapa efektif dan terintegrasi saluran akses yang digunakan pelanggan untuk berhubungan dengan organisasi saya?',
                                        'options' => [
                                            ['value' => 1, 'text' => 'Sangat Tidak Efektif'],
                                            ['value' => 2, 'text' => 'Tidak Efektif'],
                                            ['value' => 3, 'text' => 'Netral'],
                                            ['value' => 4, 'text' => 'Efektif'],
                                            ['value' => 5, 'text' => 'Sangat Efektif']
                                        ]
                                    ],
                                    [
                                        'id' => 'q7',
                                        'target' => 'solusiAplikasiPelanggan',
                                        'label' => 'Seberapa efektif solusi dan aplikasi yang memungkinkan pelanggan mendapatkan produk/layanan saya?',
                                        'options' => [
                                            ['value' => 1, 'text' => 'Sangat Tidak Efektif'],
                                            ['value' => 2, 'text' => 'Tidak Efektif'],
                                            ['value' => 3, 'text' => 'Netral'],
                                            ['value' => 4, 'text' => 'Efektif'],
                                            ['value' => 5, 'text' => 'Sangat Efektif']
                                        ]
                                    ],
                                    [
                                        'id' => 'q8',
                                        'target' => 'informasiPelanggan',
                                        'label' => 'Bagaimana saya mengelola informasi pelanggan yang digunakan dan dihasilkan dari setiap titik kontak pelanggan?',
                                        'options' => [
                                            ['value' => 1, 'text' => 'Sangat Buruk'],
                                            ['value' => 2, 'text' => 'Buruk'],
                                            ['value' => 3, 'text' => 'Cukup'],
                                            ['value' => 4, 'text' => 'Baik'],
                                            ['value' => 5, 'text' => 'Sangat Baik']
                                        ]
                                    ],
                                    [
                                        'id' => 'q9',
                                        'target' => 'prosesPelanggan',
                                        'label' => 'Apakah organisasi saya memiliki proses pelanggan yang sesuai untuk memberikan produk/layanan secara berkualitas?',
                                        'options' => [
                                            ['value' => 1, 'text' => 'Tidak ada'],
                                            ['value' => 2, 'text' => 'Tidak Sesuai'],
                                            ['value' => 3, 'text' => 'Cukup'],
                                            ['value' => 4, 'text' => 'Sesuai'],
                                            ['value' => 5, 'text' => 'Sangat Sesuai']
                                        ]
                                    ],
                                    [
                                        'id' => 'q10',
                                        'target' => 'standarSDM',
                                        'label' => 'Apakah saya memiliki sumber daya manusia yang kompeten dan termotivasi untuk memberikan produk/layanan kepada pelanggan?',
                                        'options' => [
                                            ['value' => 1, 'text' => 'Tidak Pernah'],
                                            ['value' => 2, 'text' => 'Jarang'],
                                            ['value' => 3, 'text' => 'Kadang-kadang'],
                                            ['value' => 4, 'text' => 'Sebagian Besar'],
                                            ['value' => 5, 'text' => 'Selalu']
                                        ]
                                    ],
                                    [
                                        'id' => 'q11',
                                        'target' => 'pelaporanKinerja',
                                        'label' => 'Apakah organisasi saya memiliki sistem pelaporan kinerja SPP yang sesuai untuk mengukur dampak terhadap hasil bisnis?',
                                        'options' => [
                                            ['value' => 1, 'text' => 'Tidak ada'],
                                            ['value' => 2, 'text' => 'Tidak Sesuai'],
                                            ['value' => 3, 'text' => 'Cukup'],
                                            ['value' => 4, 'text' => 'Sesuai'],
                                            ['value' => 5, 'text' => 'Sangat Sesuai']
                                        ]
                                    ]
                                ];
                            @endphp

                            @foreach($readinessQuestions as $index => $question)
                            <div class="form-group mb-4">
                                <label class="font-weight-bold">{{ $index + 1 }}. {{ $question['label'] }} <span class="text-danger">*</span></label>
                                <select class="form-control" name="readiness[{{ $question['id'] }}]" required>
                                    <option value="">-- Pilih Jawaban --</option>
                                    @foreach($question['options'] as $option)
                                    <option value="{{ $option['value'] }}" {{ old('readiness.' . $question['id']) == $option['value'] ? 'selected' : '' }}>
                                        {{ $option['text'] }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            @endforeach

                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" onclick="prevStep(2)">
                                    <i class="fas fa-arrow-left"></i> Sebelumnya
                                </button>
                                <button type="submit" class="btn btn-success rounded-pill px-4">
                                    <i class="fas fa-paper-plane"></i> Submit Evaluasi
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function nextStep(step) {
    const currentStepIndex = step - 1;
    const currentStepDiv = document.getElementById('step' + currentStepIndex);

    if (!validateStep(currentStepDiv, currentStepIndex)) {
        return;
    }

    updateStepDisplay(step);
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function prevStep(step) {
    updateStepDisplay(step);
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function calculatePriorityTotal() {
    let total = 0;
    document.querySelectorAll('.priority-input').forEach(input => {
        total += parseInt(input.value) || 0;
    });
    return total;
}

// Update total priority real-time
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.priority-input').forEach(input => {
        input.addEventListener('input', function() {
            const total = calculatePriorityTotal();
            document.getElementById('totalPriority').textContent = total;
            
            const warning = document.getElementById('priorityWarning');
            const totalError = document.getElementById('priorityTotalError');
            if (total !== 100) {
                warning.style.display = 'inline';
                if (totalError && totalError.style.display !== 'none') {
                    totalError.textContent = 'Total prioritas harus 100%.';
                }
            } else {
                warning.style.display = 'none';
                if (totalError) {
                    totalError.style.display = 'none';
                }
            }
        });
    });

    // Initial calculation & display setup
    const total = calculatePriorityTotal();
    document.getElementById('totalPriority').textContent = total;
    updateStepDisplay(1);
    bindRealTimeValidation();
});

function updateStepDisplay(step) {
    document.querySelectorAll('.step-content').forEach(div => {
        div.style.display = 'none';
    });
    document.getElementById('step' + step).style.display = 'block';

    const indicators = [
        document.querySelector('.step-item:nth-child(1)'),
        document.getElementById('indicatorStep2'),
        document.getElementById('indicatorStep3')
    ];

    indicators.forEach((indicator, index) => {
        if (!indicator) return;
        indicator.classList.toggle('active', index + 1 === step);
        indicator.classList.toggle('completed', index + 1 < step);
    });
}

function validateStep(container, stepIndex) {
    if (!container) return true;

    clearStepErrors(container);

    let valid = true;
    let firstInvalidElement = null;
    const processedRadioNames = new Set();

    const requiredFields = container.querySelectorAll('input[required], select[required], textarea[required]');

    requiredFields.forEach(field => {
        if (field.type === 'radio') {
            if (processedRadioNames.has(field.name)) return;
            processedRadioNames.add(field.name);

            const groupInputs = container.querySelectorAll('input[name="' + escapeSelector(field.name) + '"]');
            const isChecked = Array.from(groupInputs).some(input => input.checked);

            if (!isChecked) {
                valid = false;
                groupInputs.forEach(input => input.classList.add('is-invalid'));
                showFieldError(field, 'Mohon pilih salah satu opsi.');
                if (!firstInvalidElement) {
                    firstInvalidElement = field;
                }
            }
        } else {
            const value = field.value ? field.value.trim() : '';
            if (!value) {
                valid = false;
                field.classList.add('is-invalid');
                showFieldError(field, 'Field ini wajib diisi.');
                if (!firstInvalidElement) {
                    firstInvalidElement = field;
                }
            }
        }
    });

    if (stepIndex === 2) {
        const total = calculatePriorityTotal();
        const warning = document.getElementById('priorityWarning');
        const totalError = document.getElementById('priorityTotalError');

        if (total !== 100) {
            valid = false;
            if (warning) warning.style.display = 'inline';
            if (totalError) {
                totalError.textContent = 'Total prioritas harus 100%.';
                totalError.style.display = 'block';
            }
            if (!firstInvalidElement) {
                firstInvalidElement = container.querySelector('.priority-input');
            }
        } else if (totalError) {
            totalError.style.display = 'none';
        }
    }

    if (!valid && firstInvalidElement) {
        const containerElement = firstInvalidElement.closest('.form-group') || firstInvalidElement;
        containerElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
        const focusable = containerElement.querySelector('input, select, textarea');
        if (focusable) {
            focusable.focus({ preventScroll: true });
        }
    }

    return valid;
}

function showFieldError(element, message) {
    const container = element.closest('.form-group') || element.parentElement;
    if (!container) return;

    container.classList.add('has-error');

    let errorElement = container.querySelector('.field-error');
    if (!errorElement) {
        errorElement = document.createElement('small');
        errorElement.className = 'text-danger field-error mt-2';
        container.appendChild(errorElement);
    }
    errorElement.textContent = message;
}

function clearStepErrors(container) {
    container.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    container.querySelectorAll('.has-error').forEach(el => el.classList.remove('has-error'));
    container.querySelectorAll('.field-error').forEach(el => el.remove());
}

function clearFieldError(element) {
    const container = element.closest('.form-group');
    if (!container) return;
    container.classList.remove('has-error');
    const errorElement = container.querySelector('.field-error');
    if (errorElement) {
        errorElement.remove();
    }
    if (element.classList.contains('is-invalid')) {
        element.classList.remove('is-invalid');
    }
}

function bindRealTimeValidation() {
    document.querySelectorAll('input[required], select[required], textarea[required]').forEach(field => {
        const eventName = field.type === 'radio' || field.tagName === 'SELECT' ? 'change' : 'input';
        field.addEventListener(eventName, function() {
            if (field.type === 'radio') {
                const groupInputs = document.querySelectorAll('input[name="' + escapeSelector(field.name) + '"]');
                groupInputs.forEach(input => input.classList.remove('is-invalid'));
            }
            clearFieldError(field);
        });
    });
}

function escapeSelector(value) {
    return value.replace(/([\\:\[\]])/g, '\\$1');
}
</script>

<style>
.spp-landing {
    position: relative;
    min-height: calc(100vh - 120px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 60px 20px;
    background: linear-gradient(135deg, #1e3c72, #2a5298);
    color: #fff;
}

.spp-landing .overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.25);
}

.hero-content {
    position: relative;
    z-index: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 30px;
    width: 100%;
    max-width: 1100px;
}

.hero-text {
    text-align: center;
}

.hero-text h1 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 15px;
}

.hero-text p {
    font-size: 1.1rem;
    margin: 0;
    color: rgba(255, 255, 255, 0.85);
}

.hero-form {
    width: 100%;
}

.hero-form .card {
    background: #ffffff;
    color: #1f2937;
    border-radius: 24px;
}

.hero-form .card h3,
.hero-form .card label,
.hero-form .card p,
.hero-form .card small {
    color: inherit;
}

.hero-icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: rgba(33, 150, 243, 0.12);
    color: #2196f3;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
}

.step-indicator {
    display: flex;
    justify-content: space-between;
    gap: 10px;
}

.step-item {
    flex: 1;
    text-align: center;
    padding: 12px 10px;
    border-radius: 12px;
    background: #f5f7fb;
    color: #6b7280;
    transition: all 0.3s ease;
}

.step-item small {
    display: block;
    margin-top: 4px;
}

.step-item .step-number {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: rgba(33, 150, 243, 0.2);
    color: #2196f3;
    font-weight: 600;
}

.step-item.active {
    background: rgba(33, 150, 243, 0.12);
    color: #0f4c81;
}

.step-item.active .step-number {
    background: #2196f3;
    color: #fff;
}

.step-item.completed {
    background: rgba(76, 175, 80, 0.12);
    color: #388e3c;
}

.step-item.completed .step-number {
    background: #4caf50;
    color: #fff;
}

.custom-radio {
    margin-right: 15px;
}

.step-content {
    min-height: 400px;
}

.priority-input {
    text-align: right;
}

.has-error {
    border-color: #dc3545 !important;
}

.has-error .custom-control-label,
.has-error label {
    color: #dc3545 !important;
}

.field-error {
    display: block;
}

@media (max-width: 768px) {
    .spp-landing {
        padding: 40px 15px;
    }

    .hero-text h1 {
        font-size: 2rem;
    }

    .step-indicator {
        flex-direction: column;
    }
}
</style>
@endsection
