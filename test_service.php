<?php
// Quick test - simulate what the controller does
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle($request = Illuminate\Http\Request::capture());

$service = app(\App\Services\WorldBankService::class);
$data = $service->getEconomyData('ID');

echo "=== Economy Data for Indonesia (ID) ===\n";
echo "GDP:        " . ($data['gdp'] ?? 'null') . "\n";
echo "Inflation:  " . ($data['inflation'] ?? 'null') . "\n";
echo "Population: " . ($data['population'] ?? 'null') . "\n";
echo "Exports:    " . ($data['exports'] ?? 'null') . "\n";
echo "Imports:    " . ($data['imports'] ?? 'null') . "\n";
