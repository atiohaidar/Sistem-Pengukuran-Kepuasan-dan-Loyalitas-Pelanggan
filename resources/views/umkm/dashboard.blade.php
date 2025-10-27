@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h1 class="text-2xl font-bold mb-4">Dashboard UMKM - {{ $umkm->nama_usaha }}</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="p-4 border rounded">
                    <h3 class="font-semibold">Informasi Umum</h3>
                    <p class="text-gray-700">Kategori: {{ $umkm->kategori_usaha ?? '-' }}</p>
                    <p class="text-gray-700">Alamat: {{ $umkm->alamat ?? '-' }}</p>
                    <p class="text-gray-700">Status: {{ $umkm->status }}</p>
                </div>

                <div class="p-4 border rounded">
                    <h3 class="font-semibold">Ringkasan</h3>
                    <p class="text-gray-700">(Placeholder) Statistik survei & transaksi akan muncul di sini.</p>
                </div>
            </div>
        </div>
    </div>
@endsection