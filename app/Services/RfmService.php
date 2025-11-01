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
     * Hitung RFM untuk semua customer di UMKM tertentu
     */
    public function calculateForUmkm(int $umkmId): array
    {
        $customers = RfmCustomer::where('umkm_id', $umkmId)->with('transactions')->get();

        $results = [];
        foreach ($customers as $customer) {
            $rfm = $this->calculateForCustomer($customer);
            $results[] = array_merge($rfm, [
                'customer' => $customer,
                'type' => $customer->jenis_pelanggan,
            ]);
        }

        return $results;
    }

    /**
     * Hitung RFM untuk satu customer
     */
    public function calculateForCustomer(RfmCustomer $customer): array
    {
        $transactions = $customer->transactions;

        // Recency: hari sejak transaksi terakhir
        $lastTransaction = $transactions->max('tanggal_transaksi');
        $recency = $lastTransaction ? Carbon::parse($lastTransaction)->diffInDays(Carbon::now()) : 999;

        // Frequency: jumlah transaksi dalam 30 hari terakhir (atau semua jika tidak ada periode)
    $recentTransactions = $transactions->filter(fn($t) => Carbon::parse($t->tanggal_transaksi)->gte(Carbon::now()->subDays(30)));
        $frequency = $recentTransactions->count();

        // Monetary: total nilai dalam 30 hari terakhir
        $monetary = $recentTransactions->sum('nilai_transaksi');

        // Klasifikasi aktif/baru: aktif jika ada transaksi pada periode; baru jika tidak ada transaksi sebelum periode
    $previousTransactions = $transactions->filter(fn($t) => Carbon::parse($t->tanggal_transaksi)->lt(Carbon::now()->subDays(30)));
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