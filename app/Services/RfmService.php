<?php

namespace App\Services;

use App\Models\RfmCustomer;
use App\Models\RfmTransaction;
use Carbon\Carbon;

class RfmService
{
    // Default thresholds (bisa diubah atau dari config)
    protected array $thresholds = [
        'recency' => 30, // hari
        'frequency' => 5, // jumlah transaksi
        'monetary' => 50000, // nilai total
    ];

    public function __construct(array $thresholds = [])
    {
        $this->thresholds = array_merge($this->thresholds, $thresholds);
    }

    /**
     * Hitung RFM untuk semua customer di UMKM tertentu dalam rentang tanggal (opsional)
     */
    public function calculateForUmkm(int $umkmId, $startDate = null, $endDate = null): array
    {
        $end = $endDate ? Carbon::parse($endDate) : Carbon::now();
        $start = $startDate ? Carbon::parse($startDate) : $end->copy()->subDays(30);

        $customers = RfmCustomer::where('umkm_id', $umkmId)->with('transactions')->get();

        $results = [];
        foreach ($customers as $customer) {
            $rfm = $this->calculateForCustomer($customer, $start, $end);
            $results[] = array_merge($rfm, [
                'customer' => $customer,
                'type' => $customer->jenis_pelanggan,
            ]);
        }

        return $results;
    }

    /**
     * Hitung RFM untuk satu customer pada rentang tanggal tertentu
     */
    public function calculateForCustomer(RfmCustomer $customer, $startDate = null, $endDate = null): array
    {
        $end = $endDate ? Carbon::parse($endDate) : Carbon::now();
        $start = $startDate ? Carbon::parse($startDate) : $end->copy()->subDays(30);

        $transactions = $customer->transactions;

        // Recency: hari sejak transaksi terakhir dihitung terhadap tanggal akhir periode
        $lastTransaction = $transactions->max('tanggal_transaksi');
        $recency = $lastTransaction ? Carbon::parse($lastTransaction)->diffInDays($end) : 999;

        // Frequency & Monetary: dalam periode [start, end]
        $recentTransactions = $transactions->filter(function ($t) use ($start, $end) {
            $d = Carbon::parse($t->tanggal_transaksi);
            return $d->between($start, $end);
        });
        $frequency = $recentTransactions->count();
        $monetary = $recentTransactions->sum('nilai_transaksi');

        // Klasifikasi aktif/baru: aktif jika ada transaksi pada periode; baru jika tidak ada transaksi sebelum periode
        $previousTransactions = $transactions->filter(function ($t) use ($start) {
            return Carbon::parse($t->tanggal_transaksi)->lt($start);
        });
        $isActive = $frequency > 0;
        $isNew = $isActive && $previousTransactions->count() === 0;

        // Klaster berdasarkan threshold
        $cluster = $this->determineCluster($recency, $frequency, $monetary);

        return [
            'recency' => $recency,
            'frequency' => $frequency,
            'monetary' => $monetary,
            'cluster' => $cluster,
            'is_active' => $isActive,
            'is_new' => $isNew,
        ];
    }

    /**
     * Tentukan klaster berdasarkan rule
     */
    protected function determineCluster(int $recency, int $frequency, float $monetary): string
    {
        $rThreshold = $this->thresholds['recency'];
        $fThreshold = $this->thresholds['frequency'];
        $mThreshold = $this->thresholds['monetary'];

        // Jalur atas: recency > threshold_R (lama tidak transaksi)
        if ($recency > $rThreshold) {
            if ($frequency > $fThreshold) {
                return $monetary > $mThreshold ? 'Klaster Best Elite' : 'Uncategorized';
            } else {
                return $monetary > $mThreshold ? 'Klaster Good Active' : 'Worst Idle';
            }
        }
        // Jalur bawah: recency <= threshold_R (baru transaksi)
        else {
            if ($frequency > $fThreshold) {
                return $monetary > $mThreshold ? 'Klaster Best Elite' : 'Uncategorized';
            } else {
                return $monetary > $mThreshold ? 'Klaster Good Active' : 'Klaster Average Casual';
            }
        }
    }

    /**
     * Get statistik per klaster (mean, median, modus untuk R/F/M)
     */
    public function getClusterStats(array $rfmResults): array
    {
        $clusters = collect($rfmResults)->groupBy('cluster');

        $stats = [];
        foreach ($clusters as $cluster => $customers) {
            $recencies = $customers->pluck('recency')->sort()->values();
            $frequencies = $customers->pluck('frequency')->sort()->values();
            $monetaries = $customers->pluck('monetary')->sort()->values();

            $stats[$cluster] = [
                'count' => $customers->count(),
                'recency' => [
                    'mean' => $recencies->avg(),
                    'median' => $this->median($recencies),
                    'mode' => $this->mode($recencies),
                    'min' => $recencies->min() ?? 0,
                    'max' => $recencies->max() ?? 0,
                ],
                'frequency' => [
                    'mean' => $frequencies->avg(),
                    'median' => $this->median($frequencies),
                    'mode' => $this->mode($frequencies),
                    'min' => $frequencies->min() ?? 0,
                    'max' => $frequencies->max() ?? 0,
                ],
                'monetary' => [
                    'mean' => $monetaries->avg(),
                    'median' => $this->median($monetaries),
                    'mode' => $this->mode($monetaries),
                    'min' => $monetaries->min() ?? 0,
                    'max' => $monetaries->max() ?? 0,
                ],
            ];
        }

        return $stats;
    }

    /**
     * Bangun ringkasan overview untuk dashboard: omzet, pelanggan aktif (baru/lama) per jenis, dan pelanggan per klaster.
     */
    public function buildOverview(array $rfmResults): array
    {
        $overview = [
            'omzet' => 0,
            'active' => [
                'student' => ['baru' => 0, 'lama' => 0, 'total' => 0],
                'regular' => ['baru' => 0, 'lama' => 0, 'total' => 0],
                'total' => ['baru' => 0, 'lama' => 0, 'total' => 0],
            ],
            'clusterCounts' => [], // cluster => ['student'=>x,'regular'=>y,'total'=>z]
        ];

        foreach ($rfmResults as $row) {
            $type = $row['type'] ?? ($row['customer']->jenis_pelanggan ?? 'regular');
            $overview['omzet'] += (float) $row['monetary'];

            // Active breakdown
            if (!empty($row['is_active'])) {
                $isNew = !empty($row['is_new']);
                $key = $isNew ? 'baru' : 'lama';
                $overview['active'][$type][$key]++;
                $overview['active'][$type]['total']++;
                $overview['active']['total'][$key]++;
                $overview['active']['total']['total']++;
            }

            // Cluster counts by type
            $cluster = $row['cluster'];
            if (!isset($overview['clusterCounts'][$cluster])) {
                $overview['clusterCounts'][$cluster] = ['student' => 0, 'regular' => 0, 'total' => 0];
            }
            $overview['clusterCounts'][$cluster][$type]++;
            $overview['clusterCounts'][$cluster]['total']++;
        }

        return $overview;
    }

    /**
     * Hitung omzet dalam periode dan churn rate (berdasarkan periode sebelumnya dengan durasi sama)
     */
    public function buildPeriodOverview(int $umkmId, $start, $end, array $rfmResults): array
    {
        $start = $start instanceof Carbon ? $start : Carbon::parse($start);
        $end = $end instanceof Carbon ? $end : Carbon::parse($end);

        $overview = $this->buildOverview($rfmResults);

        // Omzet periode langsung dari transaksi untuk akurasi
        $overview['omzet'] = (float) RfmTransaction::where('umkm_id', $umkmId)
            ->whereBetween('tanggal_transaksi', [$start->toDateString(), $end->toDateString()])
            ->sum('nilai_transaksi');

        // Churn Rate: pelanggan aktif periode sebelumnya yang tidak aktif di periode ini
        $days = $start->diffInDays($end) + 1;
        $prevEnd = $start->copy()->subDay();
        $prevStart = $prevEnd->copy()->subDays($days - 1);

        $currentActive = RfmTransaction::where('umkm_id', $umkmId)
            ->whereBetween('tanggal_transaksi', [$start->toDateString(), $end->toDateString()])
            ->distinct('customer_id')->pluck('customer_id')->toArray();

        $prevActive = RfmTransaction::where('umkm_id', $umkmId)
            ->whereBetween('tanggal_transaksi', [$prevStart->toDateString(), $prevEnd->toDateString()])
            ->distinct('customer_id')->pluck('customer_id')->toArray();

        $prevActiveSet = collect($prevActive);
        $currentActiveSet = collect($currentActive);

        $churners = $prevActiveSet->diff($currentActiveSet)->values();
        $denom = max(count($prevActive), 0);
        $rate = $denom > 0 ? (count($churners) / $denom) : null; // null => N/A

        $overview['churn'] = [
            'rate' => $rate,
            'prev_active' => count($prevActive),
            'current_active' => count($currentActive),
            'churners' => count($churners),
            'period' => [
                'start' => $start->toDateString(),
                'end' => $end->toDateString(),
                'prev_start' => $prevStart->toDateString(),
                'prev_end' => $prevEnd->toDateString(),
            ],
        ];

        return $overview;
    }

    protected function median($values)
    {
        $count = $values->count();
        if ($count == 0) return 0;
        $middle = floor($count / 2);
        return $count % 2 ? $values[$middle] : ($values[$middle - 1] + $values[$middle]) / 2;
    }

    protected function mode($values)
    {
        $rounded = $values->map(fn($v) => (string) round($v, 2)); // cast to string
        $counts = array_count_values($rounded->toArray());
        arsort($counts);
        return key($counts);
    }
}