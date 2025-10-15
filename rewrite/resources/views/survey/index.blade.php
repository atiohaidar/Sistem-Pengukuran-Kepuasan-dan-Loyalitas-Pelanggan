@extends('layouts.app')

@section('title', 'Survei Kepuasan Pelatihan')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                Survei Kepuasan dan Loyalitas Pelanggan
            </h1>
            <p class="text-xl text-gray-600 mb-8">
                Lembaga Pelatihan Professional
            </p>
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Selamat Datang!</h2>
                <p class="text-gray-600 mb-6">
                    Terima kasih atas partisipasi Anda dalam survei ini. Survei ini bertujuan untuk mengukur
                    tingkat kepuasan dan loyalitas Anda terhadap layanan pelatihan yang kami berikan.
                </p>
                <div class="grid md:grid-cols-3 gap-6 mb-8">
                    <div class="text-center">
                        <div class="bg-blue-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-clipboard-check text-blue-600 text-2xl"></i>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2">6 Langkah Sederhana</h3>
                        <p class="text-sm text-gray-600">Survei terdiri dari 6 bagian yang mudah diisi</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-green-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-clock text-green-600 text-2xl"></i>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2">Waktu 10-15 Menit</h3>
                        <p class="text-sm text-gray-600">Survei dapat diselesaikan dalam waktu singkat</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-purple-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-shield-alt text-purple-600 text-2xl"></i>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2">Data Aman</h3>
                        <p class="text-sm text-gray-600">Data Anda dijaga kerahasiaannya</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Start Survey Button -->
        <div class="text-center">
            <form method="POST" action="{{ route('survey.start') }}">
                @csrf
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 px-8 rounded-lg text-xl transition duration-300 transform hover:scale-105 shadow-lg">
                    <i class="fas fa-play-circle mr-2"></i>
                    Mulai Survei
                </button>
            </form>
            <p class="text-gray-500 mt-4 text-sm">
                Dengan mengklik tombol di atas, Anda menyetujui untuk mengisi survei ini
            </p>
        </div>

        <!-- Survey Steps Preview -->
        <div class="mt-16 bg-white rounded-lg shadow-lg p-8">
            <h3 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Alur Survei</h3>
            <div class="grid md:grid-cols-3 lg:grid-cols-6 gap-4">
                <div class="text-center">
                    <div class="bg-blue-500 text-white rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-2 text-lg font-bold">1</div>
                    <p class="text-sm font-medium">Profil</p>
                    <p class="text-xs text-gray-500">Data diri</p>
                </div>
                <div class="text-center">
                    <div class="bg-blue-500 text-white rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-2 text-lg font-bold">2</div>
                    <p class="text-sm font-medium">Harapan</p>
                    <p class="text-xs text-gray-500">Tingkat kepentingan</p>
                </div>
                <div class="text-center">
                    <div class="bg-blue-500 text-white rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-2 text-lg font-bold">3</div>
                    <p class="text-sm font-medium">Persepsi</p>
                    <p class="text-xs text-gray-500">Kinerja layanan</p>
                </div>
                <div class="text-center">
                    <div class="bg-blue-500 text-white rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-2 text-lg font-bold">4</div>
                    <p class="text-sm font-medium">Kepuasan</p>
                    <p class="text-xs text-gray-500">Tingkat kepuasan</p>
                </div>
                <div class="text-center">
                    <div class="bg-blue-500 text-white rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-2 text-lg font-bold">5</div>
                    <p class="text-sm font-medium">Loyalitas</p>
                    <p class="text-xs text-gray-500">Tingkat loyalitas</p>
                </div>
                <div class="text-center">
                    <div class="bg-blue-500 text-white rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-2 text-lg font-bold">6</div>
                    <p class="text-sm font-medium">Saran</p>
                    <p class="text-xs text-gray-500">Kritik & saran</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection