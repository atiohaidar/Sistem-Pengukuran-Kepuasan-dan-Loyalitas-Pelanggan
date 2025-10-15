@extends('layouts.app')

@section('title', 'Penilaian Tingkat Kepentingan - Survei Kepuasan Pelatihan')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Progress Bar -->
        <div class="mb-8">
            @include('survey.partials.progress-bar')
        </div>

        <!-- Form -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                <h2 class="text-2xl font-bold text-white">II. Penilaian Tingkat Kepentingan</h2>
                <p class="text-blue-100 mt-1">Berikan penilaian seberapa penting atribut berikut memengaruhi kepuasan Anda</p>
            </div>

            <form method="POST" action="{{ route('survey.store', ['step' => 'importance']) }}" class="p-6">
                @csrf

                @if(session('success'))
                    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Reliability Section -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 bg-blue-50 p-3 rounded">Reliability (Kehandalan)</h3>
                    <div class="space-y-4">
                        @php $reliabilityData = $survey->getAnswers('importance', 'reliability') ?? []; @endphp

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">1. Kesesuaian isi post test dengan materi pelatihan yang diberikan</label>
                                <div class="flex space-x-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label class="flex items-center">
                                            <input type="radio" name="reliability[r1]" value="{{ $i }}"
                                                   {{ ($reliabilityData['r1'] ?? old('reliability.r1')) == $i ? 'checked' : '' }}
                                                   class="text-blue-600 focus:ring-blue-500" required>
                                            <span class="ml-1 text-xs">{{ $i }}</span>
                                        </label>
                                    @endfor
                                </div>
                                <div class="text-xs text-gray-500 mt-1">1=Sangat tidak penting, 5=Sangat penting</div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">2. Ketepatan waktu pelatihan sesuai dengan jadwal yang telah dijanjikan</label>
                                <div class="flex space-x-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label class="flex items-center">
                                            <input type="radio" name="reliability[r2]" value="{{ $i }}"
                                                   {{ ($reliabilityData['r2'] ?? old('reliability.r2')) == $i ? 'checked' : '' }}
                                                   class="text-blue-600 focus:ring-blue-500" required>
                                            <span class="ml-1 text-xs">{{ $i }}</span>
                                        </label>
                                    @endfor
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">3. Ketepatan waktu dalam memberikan sertifikat pelatihan</label>
                                <div class="flex space-x-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label class="flex items-center">
                                            <input type="radio" name="reliability[r3]" value="{{ $i }}"
                                                   {{ ($reliabilityData['r3'] ?? old('reliability.r3')) == $i ? 'checked' : '' }}
                                                   class="text-blue-600 focus:ring-blue-500" required>
                                            <span class="ml-1 text-xs">{{ $i }}</span>
                                        </label>
                                    @endfor
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">4. Ketepatan trainer dalam menjawab pertanyaan peserta</label>
                                <div class="flex space-x-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label class="flex items-center">
                                            <input type="radio" name="reliability[r4]" value="{{ $i }}"
                                                   {{ ($reliabilityData['r4'] ?? old('reliability.r4')) == $i ? 'checked' : '' }}
                                                   class="text-blue-600 focus:ring-blue-500" required>
                                            <span class="ml-1 text-xs">{{ $i }}</span>
                                        </label>
                                    @endfor
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">5. Materi pelatihan mudah dimengerti</label>
                                <div class="flex space-x-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label class="flex items-center">
                                            <input type="radio" name="reliability[r5]" value="{{ $i }}"
                                                   {{ ($reliabilityData['r5'] ?? old('reliability.r5')) == $i ? 'checked' : '' }}
                                                   class="text-blue-600 focus:ring-blue-500" required>
                                            <span class="ml-1 text-xs">{{ $i }}</span>
                                        </label>
                                    @endfor
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">6. Kemudahan dalam melakukan registrasi pelatihan</label>
                                <div class="flex space-x-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label class="flex items-center">
                                            <input type="radio" name="reliability[r6]" value="{{ $i }}"
                                                   {{ ($reliabilityData['r6'] ?? old('reliability.r6')) == $i ? 'checked' : '' }}
                                                   class="text-blue-600 focus:ring-blue-500" required>
                                            <span class="ml-1 text-xs">{{ $i }}</span>
                                        </label>
                                    @endfor
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">7. Kemudahan dalam melakukan pembayaran pelatihan</label>
                                <div class="flex space-x-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label class="flex items-center">
                                            <input type="radio" name="reliability[r7]" value="{{ $i }}"
                                                   {{ ($reliabilityData['r7'] ?? old('reliability.r7')) == $i ? 'checked' : '' }}
                                                   class="text-blue-600 focus:ring-blue-500" required>
                                            <span class="ml-1 text-xs">{{ $i }}</span>
                                        </label>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Assurance Section -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 bg-green-50 p-3 rounded">Assurance (Jaminan)</h3>
                    <div class="space-y-4">
                        @php $assuranceData = $survey->getAnswers('importance', 'assurance') ?? []; @endphp

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">1. Trainer/pegawai bersikap sopan</label>
                                <div class="flex space-x-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label class="flex items-center">
                                            <input type="radio" name="assurance[a1]" value="{{ $i }}"
                                                   {{ ($assuranceData['a1'] ?? old('assurance.a1')) == $i ? 'checked' : '' }}
                                                   class="text-green-600 focus:ring-green-500" required>
                                            <span class="ml-1 text-xs">{{ $i }}</span>
                                        </label>
                                    @endfor
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">2. Trainer memiliki pengetahuan yang luas mengenai materi pelatihan</label>
                                <div class="flex space-x-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label class="flex items-center">
                                            <input type="radio" name="assurance[a2]" value="{{ $i }}"
                                                   {{ ($assuranceData['a2'] ?? old('assurance.a2')) == $i ? 'checked' : '' }}
                                                   class="text-green-600 focus:ring-green-500" required>
                                            <span class="ml-1 text-xs">{{ $i }}</span>
                                        </label>
                                    @endfor
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">3. Trainer mampu menyampaikan materi pelatihan dengan cara yang mudah dipahami</label>
                                <div class="flex space-x-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label class="flex items-center">
                                            <input type="radio" name="assurance[a3]" value="{{ $i }}"
                                                   {{ ($assuranceData['a3'] ?? old('assurance.a3')) == $i ? 'checked' : '' }}
                                                   class="text-green-600 focus:ring-green-500" required>
                                            <span class="ml-1 text-xs">{{ $i }}</span>
                                        </label>
                                    @endfor
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">4. Committee service selalu dapat menyelesaikan keluhan pelanggan</label>
                                <div class="flex space-x-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label class="flex items-center">
                                            <input type="radio" name="assurance[a4]" value="{{ $i }}"
                                                   {{ ($assuranceData['a4'] ?? old('assurance.a4')) == $i ? 'checked' : '' }}
                                                   class="text-green-600 focus:ring-green-500" required>
                                            <span class="ml-1 text-xs">{{ $i }}</span>
                                        </label>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tangible Section -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 bg-purple-50 p-3 rounded">Tangible (Bukti Fisik)</h3>
                    <div class="space-y-4">
                        @php $tangibleData = $survey->getAnswers('importance', 'tangible') ?? []; @endphp

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">1. Sistem aplikasi pelatihan online yang user friendly</label>
                                <div class="flex space-x-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label class="flex items-center">
                                            <input type="radio" name="tangible[t1]" value="{{ $i }}"
                                                   {{ ($tangibleData['t1'] ?? old('tangible.t1')) == $i ? 'checked' : '' }}
                                                   class="text-purple-600 focus:ring-purple-500" required>
                                            <span class="ml-1 text-xs">{{ $i }}</span>
                                        </label>
                                    @endfor
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">2. Website menampilkan informasi terbaru</label>
                                <div class="flex space-x-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label class="flex items-center">
                                            <input type="radio" name="tangible[t2]" value="{{ $i }}"
                                                   {{ ($tangibleData['t2'] ?? old('tangible.t2')) == $i ? 'checked' : '' }}
                                                   class="text-purple-600 focus:ring-purple-500" required>
                                            <span class="ml-1 text-xs">{{ $i }}</span>
                                        </label>
                                    @endfor
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">3. Perlengkapan audio visual berfungsi dengan baik</label>
                                <div class="flex space-x-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label class="flex items-center">
                                            <input type="radio" name="tangible[t3]" value="{{ $i }}"
                                                   {{ ($tangibleData['t3'] ?? old('tangible.t3')) == $i ? 'checked' : '' }}
                                                   class="text-purple-600 focus:ring-purple-500" required>
                                            <span class="ml-1 text-xs">{{ $i }}</span>
                                        </label>
                                    @endfor
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">4. Koneksi internet host lancar selama pelatihan berlangsung</label>
                                <div class="flex space-x-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label class="flex items-center">
                                            <input type="radio" name="tangible[t4]" value="{{ $i }}"
                                                   {{ ($tangibleData['t4'] ?? old('tangible.t4')) == $i ? 'checked' : '' }}
                                                   class="text-purple-600 focus:ring-purple-500" required>
                                            <span class="ml-1 text-xs">{{ $i }}</span>
                                        </label>
                                    @endfor
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">5. Tampilan modul pelatihan menarik untuk dibaca</label>
                                <div class="flex space-x-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label class="flex items-center">
                                            <input type="radio" name="tangible[t5]" value="{{ $i }}"
                                                   {{ ($tangibleData['t5'] ?? old('tangible.t5')) == $i ? 'checked' : '' }}
                                                   class="text-purple-600 focus:ring-purple-500" required>
                                            <span class="ml-1 text-xs">{{ $i }}</span>
                                        </label>
                                    @endfor
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">6. Trainer berpenampilan rapi</label>
                                <div class="flex space-x-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label class="flex items-center">
                                            <input type="radio" name="tangible[t6]" value="{{ $i }}"
                                                   {{ ($tangibleData['t6'] ?? old('tangible.t6')) == $i ? 'checked' : '' }}
                                                   class="text-purple-600 focus:ring-purple-500" required>
                                            <span class="ml-1 text-xs">{{ $i }}</span>
                                        </label>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Empathy Section -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 bg-pink-50 p-3 rounded">Empathy (Empati)</h3>
                    <div class="space-y-4">
                        @php $empathyData = $survey->getAnswers('importance', 'empathy') ?? []; @endphp

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">1. Trainer memberikan perhatian individual kepada peserta</label>
                                <div class="flex space-x-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label class="flex items-center">
                                            <input type="radio" name="empathy[e1]" value="{{ $i }}"
                                                   {{ ($empathyData['e1'] ?? old('empathy.e1')) == $i ? 'checked' : '' }}
                                                   class="text-pink-600 focus:ring-pink-500" required>
                                            <span class="ml-1 text-xs">{{ $i }}</span>
                                        </label>
                                    @endfor
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">2. Trainer memahami kebutuhan peserta</label>
                                <div class="flex space-x-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label class="flex items-center">
                                            <input type="radio" name="empathy[e2]" value="{{ $i }}"
                                                   {{ ($empathyData['e2'] ?? old('empathy.e2')) == $i ? 'checked' : '' }}
                                                   class="text-pink-600 focus:ring-pink-500" required>
                                            <span class="ml-1 text-xs">{{ $i }}</span>
                                        </label>
                                    @endfor
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">3. Trainer memiliki waktu yang cukup untuk melayani peserta</label>
                                <div class="flex space-x-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label class="flex items-center">
                                            <input type="radio" name="empathy[e3]" value="{{ $i }}"
                                                   {{ ($empathyData['e3'] ?? old('empathy.e3')) == $i ? 'checked' : '' }}
                                                   class="text-pink-600 focus:ring-pink-500" required>
                                            <span class="ml-1 text-xs">{{ $i }}</span>
                                        </label>
                                    @endfor
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">4. Trainer memberikan pelayanan yang personal</label>
                                <div class="flex space-x-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label class="flex items-center">
                                            <input type="radio" name="empathy[e4]" value="{{ $i }}"
                                                   {{ ($empathyData['e4'] ?? old('empathy.e4')) == $i ? 'checked' : '' }}
                                                   class="text-pink-600 focus:ring-pink-500" required>
                                            <span class="ml-1 text-xs">{{ $i }}</span>
                                        </label>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Responsiveness Section -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 bg-yellow-50 p-3 rounded">Responsiveness (Daya Tanggap)</h3>
                    <div class="space-y-4">
                        @php $responsivenessData = $survey->getAnswers('importance', 'responsiveness') ?? []; @endphp

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">1. Committee service memberikan informasi yang jelas mengenai jadwal pelatihan</label>
                                <div class="flex space-x-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label class="flex items-center">
                                            <input type="radio" name="responsiveness[r1]" value="{{ $i }}"
                                                   {{ ($responsivenessData['r1'] ?? old('responsiveness.r1')) == $i ? 'checked' : '' }}
                                                   class="text-yellow-600 focus:ring-yellow-500" required>
                                            <span class="ml-1 text-xs">{{ $i }}</span>
                                        </label>
                                    @endfor
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">2. Committee service memberikan respon yang cepat terhadap pertanyaan peserta</label>
                                <div class="flex space-x-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label class="flex items-center">
                                            <input type="radio" name="responsiveness[r2]" value="{{ $i }}"
                                                   {{ ($responsivenessData['r2'] ?? old('responsiveness.r2')) == $i ? 'checked' : '' }}
                                                   class="text-yellow-600 focus:ring-yellow-500" required>
                                            <span class="ml-1 text-xs">{{ $i }}</span>
                                        </label>
                                    @endfor
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">3. Committee service memberikan respon yang cepat terhadap keluhan peserta</label>
                                <div class="flex space-x-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label class="flex items-center">
                                            <input type="radio" name="responsiveness[r3]" value="{{ $i }}"
                                                   {{ ($responsivenessData['r3'] ?? old('responsiveness.r3')) == $i ? 'checked' : '' }}
                                                   class="text-yellow-600 focus:ring-yellow-500" required>
                                            <span class="ml-1 text-xs">{{ $i }}</span>
                                        </label>
                                    @endfor
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">4. Committee service memberikan respon yang cepat terhadap permintaan peserta</label>
                                <div class="flex space-x-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label class="flex items-center">
                                            <input type="radio" name="responsiveness[r4]" value="{{ $i }}"
                                                   {{ ($responsivenessData['r4'] ?? old('responsiveness.r4')) == $i ? 'checked' : '' }}
                                                   class="text-yellow-600 focus:ring-yellow-500" required>
                                            <span class="ml-1 text-xs">{{ $i }}</span>
                                        </label>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Applicability Section -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 bg-indigo-50 p-3 rounded">Applicability (Penerapan)</h3>
                    <div class="space-y-4">
                        @php $applicabilityData = $survey->getAnswers('importance', 'applicability') ?? []; @endphp

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">1. Materi pelatihan mudah diterapkan dalam pekerjaan sehari-hari</label>
                                <div class="flex space-x-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label class="flex items-center">
                                            <input type="radio" name="applicability[ap1]" value="{{ $i }}"
                                                   {{ ($applicabilityData['ap1'] ?? old('applicability.ap1')) == $i ? 'checked' : '' }}
                                                   class="text-indigo-600 focus:ring-indigo-500" required>
                                            <span class="ml-1 text-xs">{{ $i }}</span>
                                        </label>
                                    @endfor
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">2. Materi pelatihan dapat meningkatkan produktivitas kerja</label>
                                <div class="flex space-x-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label class="flex items-center">
                                            <input type="radio" name="applicability[ap2]" value="{{ $i }}"
                                                   {{ ($applicabilityData['ap2'] ?? old('applicability.ap2')) == $i ? 'checked' : '' }}
                                                   class="text-indigo-600 focus:ring-indigo-500" required>
                                            <span class="ml-1 text-xs">{{ $i }}</span>
                                        </label>
                                    @endfor
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">3. Materi pelatihan dapat meningkatkan kualitas kerja</label>
                                <div class="flex space-x-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label class="flex items-center">
                                            <input type="radio" name="applicability[ap3]" value="{{ $i }}"
                                                   {{ ($applicabilityData['ap3'] ?? old('applicability.ap3')) == $i ? 'checked' : '' }}
                                                   class="text-indigo-600 focus:ring-indigo-500" required>
                                            <span class="ml-1 text-xs">{{ $i }}</span>
                                        </label>
                                    @endfor
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">4. Materi pelatihan dapat meningkatkan kompetensi pegawai</label>
                                <div class="flex space-x-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label class="flex items-center">
                                            <input type="radio" name="applicability[ap4]" value="{{ $i }}"
                                                   {{ ($applicabilityData['ap4'] ?? old('applicability.ap4')) == $i ? 'checked' : '' }}
                                                   class="text-indigo-600 focus:ring-indigo-500" required>
                                            <span class="ml-1 text-xs">{{ $i }}</span>
                                        </label>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="mt-8 flex justify-between">
                    <div>
                        @if($canGoBack)
                            <a href="{{ route('survey.step', ['step' => \App\Http\Controllers\SurveyController::getPreviousStep($step)]) }}"
                               class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                <i class="fas fa-arrow-left mr-1"></i>Kembali
                            </a>
                        @endif
                    </div>
                    <div>
                        <button type="submit" name="action" value="next" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md font-medium transition duration-200">
                            Lanjut <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Survey Local Storage Management
document.addEventListener('DOMContentLoaded', function() {
    const sessionToken = '{{ $survey->session_token }}';
    const step = '{{ $step }}';
    const storageKey = `survey_${sessionToken}_${step}`;

    // Load saved data from localStorage
    loadFromLocalStorage();

    // Save to localStorage on input change
    document.querySelectorAll('input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', saveToLocalStorage);
    });

    function saveToLocalStorage() {
        const formData = new FormData(document.querySelector('form'));
        const data = {};

        // Group radio buttons by name
        document.querySelectorAll('input[type="radio"]:checked').forEach(radio => {
            const name = radio.name;
            const value = radio.value;

            // Handle nested structure for reliability, assurance, etc.
            if (name.includes('[')) {
                const parts = name.replace(']', '').split('[');
                if (!data[parts[0]]) data[parts[0]] = {};
                data[parts[0]][parts[1]] = value;
            } else {
                data[name] = value;
            }
        });

        localStorage.setItem(storageKey, JSON.stringify(data));
    }

    function loadFromLocalStorage() {
        const savedData = localStorage.getItem(storageKey);
        if (!savedData) return;

        try {
            const data = JSON.parse(savedData);

            // Restore radio button selections
            Object.keys(data).forEach(section => {
                if (typeof data[section] === 'object') {
                    // Handle nested sections like reliability[r1]
                    Object.keys(data[section]).forEach(key => {
                        const radioName = `${section}[${key}]`;
                        const radioValue = data[section][key];
                        const radio = document.querySelector(`input[name="${radioName}"][value="${radioValue}"]`);
                        if (radio) radio.checked = true;
                    });
                } else {
                    // Handle simple fields
                    const radio = document.querySelector(`input[name="${section}"][value="${data[section]}"]`);
                    if (radio) radio.checked = true;
                }
            });
        } catch (e) {
            console.warn('Failed to load survey data from localStorage:', e);
        }
    }

    // Clear localStorage when form is submitted successfully
    document.querySelector('form').addEventListener('submit', function() {
        // Keep data in localStorage until successfully saved to server
        // Will be cleared on successful redirect to next step
    });
});

// Clear localStorage for this step when page loads (after successful save)
if (window.location.search.includes('success')) {
    const sessionToken = '{{ $survey->session_token }}';
    const step = '{{ $step }}';
    const storageKey = `survey_${sessionToken}_${step}`;
    localStorage.removeItem(storageKey);
}
</script>
@endsection