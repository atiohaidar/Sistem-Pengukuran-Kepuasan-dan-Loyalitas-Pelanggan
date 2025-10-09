<?php

namespace App\Exports;
use Illuminate\Support\Facades\DB;
use App\Karyawanpersonal;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class KaryawanExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    /*public function collection()
    {
        $karyawandata = DB::table('tabel_karyawan_personal')
        ->join('tabel_karyawan_data', 'tabel_karyawan_personal.id_karyawan_personal', '=', 'tabel_karyawan_data.id_karyawan_personal')
        ->join('tabel_jabatan', 'tabel_jabatan.id_jabatan', '=', 'tabel_karyawan_data.jabatan')
        ->join('tabel_level', 'tabel_level.id_level', '=', 'tabel_karyawan_data.level')
        ->join('tabel_departemen', 'tabel_departemen.id_departemen', '=', 'tabel_karyawan_data.departemen')
        ->join('tabel_agama', 'tabel_agama.id_agama', '=', 'tabel_karyawan_personal.agama')
        ->select('tabel_karyawan_data.npk','tabel_karyawan_personal.nama_lengkap',
                  'tabel_jabatan.jabatan','tabel_level.level', 'tabel_departemen.departemen', 'tabel_agama.agama')
        ->orderBy('tabel_karyawan_data.npk','asc')
        ->get();

        return $karyawandata;
    }

    public function headings(): array
    {
        return [
            'NPK',
            'NAMA LENGKAP',
            'JABATAN',
            'LEVEL',
            'GOLONGAN',
            'DEPARTEMEN',
            'TEMPAT LAHIR',
            'TANGGAL LAHIR',
            'JENIS KELAMIN',
            'SUKU',
            'AGAMA',
            'STATUS',
            'ALAMAT SESUAI KTP',
            'KODE POS',
            'ALAMAT TEMPAT TINGGAL(DOMISILI)',
            'NO KARTU KELUARGA',
            'NO KTP',
            'NO TELP',
            'NO HP',
            'EMAIL PERUSAHAAN',
            'EMAIL PRIBADI',
            'NPWP',
            'TANGGAL MASUK',
            'MASA KERJA',
            'KONTRAK_MULAI',
            'KONTRAK_AKHIR',
            'EVALUASI_MULAI',
            'EVALUASI_AKHIR',
            'NO SPK',
            'KONTRAK KE',
            'STATUS KEPEGAWAIAN',
            'MASA KONTRAK',
            'TINGKAT',
            'NAMA SEKOLAH',
            'JURUSAN',
            'IPK',
            'KOTA',
            'TAHUN LULUS',
            'NAMA S/I',
            'TGL LAHIR S/I',
            'NAMA IBU',
            'TGL LAHIR IBU',
            'NAMA AYAH',
            'TGL LAHIR AYAH',
            'NAMA ANAK',
            'NAMA KONTAK DARURAT',
            'KONTAK',
            'HOBI',
            'BPJS KESEHATAN',
            'BPJS KETENAGAKERJAAN',
            'GREAT EASTERN',
            'BANK',
            'NO REKENING',
            'ID FINGER',

        ];
    }*/

    public function view(): View
    {
        $karyawandata = DB::table('tabel_karyawan_personal')
        ->join('tabel_karyawan_data', 'tabel_karyawan_personal.id_karyawan_personal', '=', 'tabel_karyawan_data.id_karyawan_personal')
        ->join('tabel_jabatan', 'tabel_jabatan.id_jabatan', '=', 'tabel_karyawan_data.jabatan')
        ->join('tabel_level', 'tabel_level.id_level', '=', 'tabel_karyawan_data.level')
        ->join('tabel_karyawan_pendidikan', 'tabel_karyawan_pendidikan.id_karyawan_personal', '=', 'tabel_karyawan_personal.id_karyawan_personal')
        
        ->join('tabel_departemen', 'tabel_departemen.id_departemen', '=', 'tabel_karyawan_data.departemen')
        ->join('tabel_agama', 'tabel_agama.id_agama', '=', 'tabel_karyawan_personal.agama')

        ->select('tabel_karyawan_personal.*', 'tabel_karyawan_data.*',
                  'tabel_jabatan.jabatan','tabel_level.level', 'tabel_departemen.departemen', 'tabel_agama.agama','tabel_karyawan_pendidikan.*')
        ->orderBy('tabel_karyawan_data.npk','asc')
        ->get();

        return view('karyawan_personal.exc_report', [
            'karyawandata' => $karyawandata
        ]);
    }

}
