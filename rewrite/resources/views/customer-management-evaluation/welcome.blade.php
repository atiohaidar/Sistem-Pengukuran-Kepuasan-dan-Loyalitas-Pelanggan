<x-mylayout>
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Evaluasi Sistem Pengelolaan Pelanggan
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Alat bantu untuk UMKM dalam menilai sistem pengelolaan pelanggan secara objektif.
            </p>
        </div>
            <form class="mt-8 space-y-6" action="{{ route('customer-management-evaluation.maturity') }}" method="POST">
            @csrf
            <div>
                <label for="company_name" class="block text-sm font-medium text-gray-700">
                    Nama Perusahaan
                </label>
                <input id="company_name" name="company_name" type="text" required
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                       placeholder="Masukkan nama perusahaan Anda">
                @error('company_name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <button type="submit"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Mulai Asesmen
                </button>
            </div>
        </form>
    </div>
</div>
</x-mylayout>