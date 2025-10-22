<x-guest-layout title="Survei Kepuasan Produk">
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-16 px-4">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full mb-6 shadow-lg">
                <i class="fas fa-poll-h text-white text-3xl"></i>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-4 bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent leading-tight">
                Survei Kepuasan dan Loyalitas Pelanggan - Produk
            </h1>
            <p class="text-xl text-gray-600 mb-2 font-medium">
                Survei Kepuasan Produk
            </p>
            <div class="w-32 h-1 bg-gradient-to-r from-blue-500 to-indigo-500 mx-auto rounded-full mb-8"></div>
        </div>
            <div class="bg-white rounded-xl shadow-xl p-8 mb-8 border border-gray-100">
                <div class="text-center mb-6">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full mb-4">
                        <i class="fas fa-clipboard-check text-white text-2xl"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Selamat Datang!</h2>
                    <div class="w-24 h-1 bg-gradient-to-r from-blue-500 to-indigo-500 mx-auto rounded-full"></div>
                </div>
                <p class="text-gray-600 mb-8 text-lg leading-relaxed text-center max-w-2xl mx-auto">
                    Terima kasih atas partisipasi Anda dalam survei ini. Survei ini bertujuan untuk mengukur
                    tingkat kepuasan dan loyalitas Anda terhadap produk kami.
                </p>
            </div>

        <!-- Start Survey Button -->
        <div class="text-center">
            <form method="POST" action="{{ route('survey.produk.start') }}">
                @csrf
                    <button type="submit" class="group bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-bold py-5 px-10 rounded-xl text-xl transition-all duration-300 transform hover:scale-105 hover:shadow-2xl shadow-lg border-2 border-transparent hover:border-blue-300">
                    <i class="fas fa-play-circle mr-3 group-hover:animate-pulse"></i>
                    Mulai Survei Produk
                    <i class="fas fa-arrow-right ml-3 group-hover:translate-x-1 transition-transform duration-300"></i>
                </button>
            </form>
            <p class="text-gray-500 mt-6 text-sm max-w-md mx-auto leading-relaxed">
                Dengan mengklik tombol di atas, Anda menyetujui untuk mengisi survei ini dengan jujur dan bertanggung jawab
            </p>
        </div>


    </div>
</div>
</x-mylayout>
