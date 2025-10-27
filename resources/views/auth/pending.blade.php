<x-guest-layout title="Pending">

    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl w-full mx-auto">
            <div class="text-center mb-8">
                <div class="flex items-center justify-center mb-6">
                    <div class="bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 p-4 rounded-full shadow-2xl">
                        <i class="fas fa-hourglass-half text-white text-2xl"></i>
                    </div>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800">Pendaftaran Akun Sedang Diproses</h1>
                <p class="text-gray-600 mt-2">Terima kasih telah mendaftar. Tim kami akan meninjau informasi Akun Anda.
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow-2xl p-8">
                <div class="grid md:grid-cols-2 gap-6 items-center">
                    <div>
                        <h2 class="text-xl font-semibold mb-2">Status Pendaftaran</h2>
                        <p class="text-gray-700 mb-4">Akun dan profil UMKM Anda saat ini berstatus
                            <strong>Pending</strong>. Proses persetujuan biasanya memakan waktu 1–2 hari kerja.
                        </p>

                        <ul class="space-y-3 text-sm text-gray-600">
                            <li class="flex items-start"><i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                                Pastikan email verifikasi telah Anda konfirmasi.</li>
                            <li class="flex items-start"><i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                                Jika ada dokumen yang harus dilengkapi, Anda akan menerima notifikasi.</li>
                            <li class="flex items-start"><i class="fas fa-phone text-blue-500 mr-3 mt-1"></i> Untuk
                                bantuan, hubungi: <a class="text-indigo-600 font-medium"
                                    href="mailto:admin@example.com">admin@example.com</a></li>
                        </ul>

                        <div class="mt-6">
                            <a href="{{ route('welcome') }}"
                                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-blue-600 text-white rounded-lg shadow hover:opacity-95">Kembali
                                ke Halaman Utama</a>
                        </div>
                    </div>

                    <div class="p-4 bg-gradient-to-r from-green-50 to-cyan-50 rounded-lg border border-green-100">
                        <h3 class="font-semibold mb-2">Apa yang terjadi selanjutnya?</h3>
                        <ol class="list-decimal list-inside text-gray-700 text-sm space-y-2">
                            <li>Tim admin meninjau data Anda.</li>
                            <li>Jika data lengkap, admin akan menyetujui dan Anda akan menerima email konfirmasi.</li>
                            <li>Setelah disetujui, Anda bisa mengakses fitur manajemen UMKM seperti membuat survei dan
                                impor transaksi.</li>
                        </ol>

                        <div class="mt-4 text-xs text-gray-500">Estimasi waktu proses bergantung pada ketersediaan
                            admin. Untuk percepatan, hubungi kontak admin.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-guest-layout>