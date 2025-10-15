<?php

namespace App\Exports;

use App\Models\CustomerManagementEvaluation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CustomerEvaluationsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = CustomerManagementEvaluation::query();

        // Apply same filters as in controller
        if (isset($this->filters['search']) && !empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where('company_name', 'like', "%{$search}%")
                  ->orWhere('token', 'like', "%{$search}%");
        }

        if (isset($this->filters['status']) && $this->filters['status'] !== '') {
            if ($this->filters['status'] === 'completed') {
                $query->where('completed', true);
            } elseif ($this->filters['status'] === 'incomplete') {
                $query->where('completed', false);
            }
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Token',
            'Nama Perusahaan',
            'Status',
            'Tanggal Dibuat',
            'Tanggal Diupdate',
            // Maturity scores
            'Visi',
            'Strategi',
            'Pengalaman Konsumen',
            'Kolaborasi Organisasi',
            'Proses',
            'Informasi',
            'Teknologi',
            'Matriks',
            // Priority scores
            'Kepemimpinan Strategis (%)',
            'Budaya Organisasi (%)',
            'Proses Bisnis (%)',
            'Teknologi Informasi (%)',
            'Sumber Daya Manusia (%)',
            'Pengukuran Kinerja (%)',
            // Readiness scores
            'Kesiapan Kepemimpinan Strategis',
            'Kesiapan Budaya Organisasi',
            'Kesiapan Proses Bisnis',
            'Kesiapan Teknologi Informasi',
            'Kesiapan Sumber Daya Manusia',
            'Kesiapan Pengukuran Kinerja',
        ];
    }

    public function map($evaluation): array
    {
        return [
            $evaluation->id,
            $evaluation->token,
            $evaluation->company_name,
            $evaluation->completed ? 'Selesai' : 'Belum Selesai',
            $evaluation->created_at->format('d/m/Y H:i:s'),
            $evaluation->updated_at->format('d/m/Y H:i:s'),
            // Maturity data
            $evaluation->maturity_data['visi'] ?? '-',
            $evaluation->maturity_data['strategi'] ?? '-',
            $evaluation->maturity_data['pengalamanKonsumen'] ?? '-',
            $evaluation->maturity_data['kolaborasiOrganisasi'] ?? '-',
            $evaluation->maturity_data['proses'] ?? '-',
            $evaluation->maturity_data['informasi'] ?? '-',
            $evaluation->maturity_data['teknologi'] ?? '-',
            $evaluation->maturity_data['matriks'] ?? '-',
            // Priority data
            $evaluation->priority_data['kepemimpinan_strategis'] ?? '-',
            $evaluation->priority_data['budaya_organisasi'] ?? '-',
            $evaluation->priority_data['proses_bisnis'] ?? '-',
            $evaluation->priority_data['teknologi_informasi'] ?? '-',
            $evaluation->priority_data['sumber_daya_manusia'] ?? '-',
            $evaluation->priority_data['pengukuran_kinerja'] ?? '-',
            // Readiness data
            $evaluation->readiness_data['q1'] ?? '-',
            $evaluation->readiness_data['q2'] ?? '-',
            $evaluation->readiness_data['q3'] ?? '-',
            $evaluation->readiness_data['q4'] ?? '-',
            $evaluation->readiness_data['q5'] ?? '-',
            $evaluation->readiness_data['q6'] ?? '-',
        ];
    }
}