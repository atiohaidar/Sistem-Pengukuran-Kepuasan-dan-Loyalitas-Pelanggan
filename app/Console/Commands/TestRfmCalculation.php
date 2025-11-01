<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestRfmCalculation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rfm:test {--umkm_id=1} {--recency=30} {--frequency=5} {--monetary=50000}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test RFM calculation with sample data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $umkmId = $this->option('umkm_id');
        $thresholds = [
            'recency' => (int) $this->option('recency'),
            'frequency' => (int) $this->option('frequency'),
            'monetary' => (float) $this->option('monetary'),
        ];

        $service = new \App\Services\RfmService($thresholds);
        $results = $service->calculateForUmkm($umkmId);

        $this->info("RFM Calculation for UMKM {$umkmId} with thresholds: " . json_encode($thresholds));
        $this->table(
            ['Customer', 'Custom ID', 'Recency', 'Frequency', 'Monetary', 'Cluster'],
            collect($results)->map(fn($r) => [
                $r['customer']->nama_lengkap,
                $r['customer']->custom_id,
                $r['recency'],
                $r['frequency'],
                $r['monetary'],
                $r['cluster'],
            ])
        );

        $stats = $service->getClusterStats($results);
        $this->info('Cluster Stats:');
        foreach ($stats as $cluster => $stat) {
            $this->line("Cluster: {$cluster} (Count: {$stat['count']})");
            $this->line("  Recency - Mean: {$stat['recency']['mean']}, Median: {$stat['recency']['median']}, Mode: {$stat['recency']['mode']}");
            $this->line("  Frequency - Mean: {$stat['frequency']['mean']}, Median: {$stat['frequency']['median']}, Mode: {$stat['frequency']['mode']}");
            $this->line("  Monetary - Mean: {$stat['monetary']['mean']}, Median: {$stat['monetary']['median']}, Mode: {$stat['monetary']['mode']}");
        }
    }
}
