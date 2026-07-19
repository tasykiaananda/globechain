<?php
// Test World Bank API for Indonesia inflation
$url = 'https://api.worldbank.org/v2/country/ID/indicator/FP.CPI.TOTL.ZG?format=json&per_page=5&date=2018:2024';
echo "Testing URL: $url\n\n";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
$resp = curl_exec($ch);
$err = curl_error($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Code: $code\n";
echo "Error: $err\n\n";

if ($resp) {
    $data = json_decode($resp, true);
    echo "=== RAW RESPONSE ===\n";
    print_r($data);
} else {
    echo "No response received.\n";
}

// Also test mrnev=1
echo "\n\n=== Testing mrnev=1 ===\n";
$url2 = 'https://api.worldbank.org/v2/country/ID/indicator/FP.CPI.TOTL.ZG?format=json&mrnev=1';
$ch2 = curl_init();
curl_setopt($ch2, CURLOPT_URL, $url2);
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch2, CURLOPT_TIMEOUT, 30);
curl_setopt($ch2, CURLOPT_CONNECTTIMEOUT, 15);
curl_setopt($ch2, CURLOPT_USERAGENT, 'Mozilla/5.0');
$resp2 = curl_exec($ch2);
$err2 = curl_error($ch2);
$code2 = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
curl_close($ch2);

echo "HTTP Code: $code2\n";
echo "Error: $err2\n\n";

if ($resp2) {
    $data2 = json_decode($resp2, true);
    print_r($data2);
} else {
    echo "No response received.\n";
}
