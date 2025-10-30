<x-guest-layout>
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Evaluasi Sistem Pengelolaan Pelanggan
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Alat bantu untuk UMKM dalam menilai sistem pengelolaan pelanggan secara objektif.
            </p>
        </div>

        <div class="bg-white py-8 px-6 shadow-lg rounded-lg">
            <div class="text-center">
                <h3 class="text-lg font-medium text-gray-900 mb-2">Selamat Datang!</h3>
                <p class="text-sm text-gray-600 mb-6">
                    Anda akan mengisi evaluasi untuk perusahaan:
                </p>
                <div class="bg-gray-50 rounded-md p-4 mb-6">
                    <h4 class="text-lg font-semibold text-gray-900">{{ $umkm->nama_usaha }}</h4>
                    @if($umkm->deskripsi)
                        <p class="text-sm text-gray-600 mt-1">{{ $umkm->deskripsi }}</p>
                    @endif
                </div>
            </div>

            <form class="space-y-6" action="{{ route('customer-management-evaluation.maturity', ['token' => $token]) }}" method="POST">
                @csrf
                <div>
                    <button type="submit"
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Mulai Evaluasi CRM
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-xs text-gray-500">
                    Waktu pengerjaan: ± 15-20 menit
                </p>
            </div>
        </div>
    </div>
</div>
</x-guest-layout>