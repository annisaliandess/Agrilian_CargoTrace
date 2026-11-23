<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$views = [
    'commodities.index',
    'dashboard.index',
    'shipments.index',
];

foreach ($views as $v) {
    try {
        echo "Testing view $v...\n";
        $rendered = view($v, [
            'commodities' => collect([]),
            'shipments' => new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10),
            'metrics' => [
                'total_shipments' => 0,
                'in_transit' => 0,
                'delivered' => 0,
                'alerts_count' => 0,
                'total_tonnage' => 0,
                'total_customs_value' => 0,
                'multimodal_breakdown' => [],
                'recent_alerts' => collect([]),
                'active_corridors' => [],
                'origin_distribution' => [],
                'destination_distribution' => [],
                'status_counts' => [],
            ],
            'recentShipments' => collect([]),
            'liveAlerts' => collect([]),
            'corridorStatuses' => [],
            'stats' => [],
        ])->render();
        echo "$v: SUCCESS (" . strlen($rendered) . " bytes)\n";
    } catch (\Throwable $e) {
        echo "$v: ERROR -> " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine() . "\n";
    }
}
