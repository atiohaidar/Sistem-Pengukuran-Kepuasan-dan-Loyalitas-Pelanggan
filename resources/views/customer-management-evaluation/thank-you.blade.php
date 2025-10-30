<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Terima Kasih') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-green-50 to-emerald-100 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl border-0 relative">
                <div class="absolute inset-0 bg-gradient-to-r from-green-500 to-emerald-500 rounded-2xl opacity-10">
                </div>
                <div class="relative bg-white sm:rounded-2xl p-8 text-center">
                    <!-- Success Icon -->
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-6">
                        <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>

                    <!-- Title -->
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">
                        Terima Kasih!
                    </h1>

                    <!-- Message -->
                    <p class="text-lg text-gray-600 mb-6">
                        Evaluasi Customer Relationship Management untuk <strong>{{ $umkm->nama_usaha }}</strong> telah
                        berhasil diselesaikan.
                    </p>

                    <!-- Additional Info -->
                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <p class="text-sm text-gray-500">
                            Data evaluasi Anda telah disimpan dan akan digunakan untuk menghasilkan laporan analisis
                            yang komprehensif untuk pengembangan strategi CRM perusahaan.
                        </p>
                    </div>

                    <!-- Back to Home -->
                    <div class="flex justify-center">
                        <a href="{{ url('/') }}"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:from-green-600 hover:to-emerald-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg>
                            Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>