@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <span class="text-sm font-medium text-gray-700">Langkah 3 dari 3</span>
                <span class="text-sm font-medium text-gray-700">100%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-indigo-600 h-2 rounded-full" style="width: 100%"></div>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Audit Sistem Pengelolaan Pelanggan</h2>
            <p class="text-gray-600 mb-6">Pada tahap ini, pilih kondisi sistem manajemen pelanggan yang paling sesuai dengan perusahaan anda.</p>

            <form action="{{ route('customer-management-evaluation.store-readiness') }}" method="POST">
                @csrf

                <!-- Readiness Questions -->
                <div class="space-y-6">
                    @php
                        $questions = [
                            'q1' => [
                                'label' => 'Apakah organisasi saya menunjukkan kepemimpinan dalam proses menjalankan SPP?',
                                'options' => [
                                    1 => 'Sangat Tidak Setuju',
                                    2 => 'Tidak Setuju',
                                    3 => 'Netral',
                                    4 => 'Setuju',
                                    5 => 'Sangat Setuju',
                                ]
                            ],
                            'q2' => [
                                'label' => 'Bagaimana posisi perusahaan saya jika dibandingkan dengan perusahaan lainnya?',
                                'options' => [
                                    1 => 'Jauh Lebih Buruk',
                                    2 => 'Lebih Buruk',
                                    3 => 'Setara',
                                    4 => 'Lebih Baik',
                                    5 => 'Jauh Lebih Baik',
                                ]
                            ],
                            'q3' => [
                                'label' => 'Seberapa puas pelanggan saya terhadap produk dan layanan yang ditawarkan?',
                                'options' => [
                                    1 => 'Sangat Tidak Puas',
                                    2 => 'Tidak Puas',
                                    3 => 'Netral',
                                    4 => 'Puas',
                                    5 => 'Sangat Puas',
                                ]
                            ],
                            'q4' => [
                                'label' => 'Berapa nilai jangka panjang pelanggan saya?',
                                'options' => [
                                    1 => 'Sangat Rendah',
                                    2 => 'Rendah',
                                    3 => 'Sedang',
                                    4 => 'Tinggi',
                                    5 => 'Sangat Tinggi',
                                ]
                            ],
                            'q5' => [
                                'label' => 'Apakah saya sudah menggunakan biaya melayani pelanggan secara efisien?',
                                'options' => [
                                    1 => 'Sangat Tidak Efisien',
                                    2 => 'Tidak Efisien',
                                    3 => 'Netral',
                                    4 => 'Efisien',
                                    5 => 'Sangat Efisien',
                                ]
                            ],
                            'q6' => [
                                'label' => 'Seberapa efektif dan terintegrasi saluran akses yang digunakan pelanggan untuk berhubungan dengan organisasi saya?',
                                'options' => [
                                    1 => 'Sangat Tidak Efektif',
                                    2 => 'Tidak Efektif',
                                    3 => 'Netral',
                                    4 => 'Efektif',
                                    5 => 'Sangat Efektif',
                                ]
                            ],
                            'q7' => [
                                'label' => 'Seberapa efektif solusi dan aplikasi yang memungkinkan pelanggan mendapatkan produk/layanan saya?',
                                'options' => [
                                    1 => 'Sangat Tidak Efektif',
                                    2 => 'Tidak Efektif',
                                    3 => 'Netral',
                                    4 => 'Efektif',
                                    5 => 'Sangat Efektif',
                                ]
                            ],
                            'q8' => [
                                'label' => 'Bagaimana saya mengelola informasi pelanggan yang digunakan dan dihasilkan dari setiap titik kontak pelanggan?',
                                'options' => [
                                    1 => 'Sangat Buruk',
                                    2 => 'Buruk',
                                    3 => 'Cukup',
                                    4 => 'Baik',
                                    5 => 'Sangat Baik',
                                ]
                            ],
                            'q9' => [
                                'label' => 'Apakah organisasi saya memiliki proses pelanggan yang sesuai untuk memberikan produk/layanan secara berkualitas?',
                                'options' => [
                                    1 => 'Tidak ada',
                                    2 => 'Tidak Sesuai',
                                    3 => 'Cukup',
                                    4 => 'Sesuai',
                                    5 => 'Sangat Sesuai',
                                ]
                            ],
                            'q10' => [
                                'label' => 'Apakah saya memiliki sumber daya manusia yang kompeten dan termotivasi untuk memberikan produk/layanan kepada pelanggan?',
                                'options' => [
                                    1 => 'Tidak Pernah',
                                    2 => 'Jarang',
                                    3 => 'Kadang-kadang',
                                    4 => 'Sebagian Besar',
                                    5 => 'Selalu',
                                ]
                            ],
                            'q11' => [
                                'label' => 'Apakah organisasi saya memiliki sistem pelaporan kinerja SPP yang sesuai untuk mengukur dampak terhadap hasil bisnis?',
                                'options' => [
                                    1 => 'Tidak ada',
                                    2 => 'Tidak Sesuai',
                                    3 => 'Cukup',
                                    4 => 'Sesuai',
                                    5 => 'Sangat Sesuai',
                                ]
                            ],
                        ];
                    @endphp

                    @foreach($questions as $key => $question)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                {{ $question['label'] }}
                            </label>
                            <select name="{{ $key }}" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
                                <option value="">Pilih...</option>
                                @foreach($question['options'] as $value => $text)
                                    <option value="{{ $value }}" {{ ($data['readiness'][$key] ?? 3) == $value ? 'selected' : '' }}>
                                        {{ $value }} - {{ $text }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                </div>

                <!-- Navigation Buttons -->
                <div class="mt-8 flex justify-between">
                    <a href="{{ route('customer-management-evaluation.priority') }}"
                       class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Kembali
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Lihat Hasil
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection