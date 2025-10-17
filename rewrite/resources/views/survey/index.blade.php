<x-guest-layout title="Survei Kepuasan Pelatihan">
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-16 px-4">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full mb-6 shadow-lg">
                <i class="fas fa-poll-h text-white text-3xl"></i>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-4 bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent leading-tight">
                Survei Kepuasan dan Loyalitas Pelanggan
            </h1>
            <p class="text-xl text-gray-600 mb-2 font-medium">
                Lembaga Pelatihan Professional
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
                    tingkat kepuasan dan loyalitas Anda terhadap layanan pelatihan yang kami berikan.
                </p>

                <!-- <div class="grid md:grid-cols-3 lg:grid-cols-6 gap-6">
                    <div class="text-center group">
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-xl w-14 h-14 flex items-center justify-center mx-auto mb-3 text-xl font-bold shadow-lg group-hover:shadow-xl transition-all duration-300 group-hover:scale-105">
                            <i class="fas fa-user"></i>
                        </div>
                        <p class="text-sm font-semibold text-gray-800 mb-1">Profil</p>
                        <p class="text-xs text-gray-500">Data diri</p>
                    </div>

                    <div class="text-center group">
                        <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 text-white rounded-xl w-14 h-14 flex items-center justify-center mx-auto mb-3 text-xl font-bold shadow-lg group-hover:shadow-xl transition-all duration-300 group-hover:scale-105">
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="text-sm font-semibold text-gray-800 mb-1">Harapan</p>
                        <p class="text-xs text-gray-500">Tingkat kepentingan</p>
                    </div>

                    <div class="text-center group">
                        <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-xl w-14 h-14 flex items-center justify-center mx-auto mb-3 text-xl font-bold shadow-lg group-hover:shadow-xl transition-all duration-300 group-hover:scale-105">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <p class="text-sm font-semibold text-gray-800 mb-1">Persepsi</p>
                        <p class="text-xs text-gray-500">Kinerja layanan</p>
                    </div>

                    <div class="text-center group">
                        <div class="bg-gradient-to-br from-green-500 to-green-600 text-white rounded-xl w-14 h-14 flex items-center justify-center mx-auto mb-3 text-xl font-bold shadow-lg group-hover:shadow-xl transition-all duration-300 group-hover:scale-105">
                            <i class="fas fa-smile"></i>
                        </div>
                        <p class="text-sm font-semibold text-gray-800 mb-1">Kepuasan</p>
                        <p class="text-xs text-gray-500">Tingkat kepuasan</p>
                    </div>

                    <div class="text-center group">
                        <div class="bg-gradient-to-br from-teal-500 to-teal-600 text-white rounded-xl w-14 h-14 flex items-center justify-center mx-auto mb-3 text-xl font-bold shadow-lg group-hover:shadow-xl transition-all duration-300 group-hover:scale-105">
                            <i class="fas fa-heart"></i>
                        </div>
                        <p class="text-sm font-semibold text-gray-800 mb-1">Loyalitas</p>
                        <p class="text-xs text-gray-500">Tingkat loyalitas</p>
                    </div>

                    <div class="text-center group">
                        <div class="bg-gradient-to-br from-orange-500 to-orange-600 text-white rounded-xl w-14 h-14 flex items-center justify-center mx-auto mb-3 text-xl font-bold shadow-lg group-hover:shadow-xl transition-all duration-300 group-hover:scale-105">
                            <i class="fas fa-comments"></i>
                        </div>
                        <p class="text-sm font-semibold text-gray-800 mb-1">Saran</p>
                        <p class="text-xs text-gray-500">Kritik & saran</p>
                    </div>
                </div> -->
            </div>
        </div>

        <!-- Start Survey Button -->
        <div class="text-center">
            <form method="POST" action="{{ route('survey.start') }}">
                @csrf
                    <button type="submit" class="group bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-bold py-5 px-10 rounded-xl text-xl transition-all duration-300 transform hover:scale-105 hover:shadow-2xl shadow-lg border-2 border-transparent hover:border-blue-300">
                    <i class="fas fa-play-circle mr-3 group-hover:animate-pulse"></i>
                    Mulai Survei
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