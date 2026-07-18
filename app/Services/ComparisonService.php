<?php

namespace App\Services;

/**
 * ComparisonService
 * 
 * Service untuk mengagregasi seluruh data intelijen suatu negara
 * dari berbagai API (Country, Weather, WorldBank, ExchangeRate, News, Risk)
 * menjadi satu paket data siap pakai untuk fitur Comparison Engine & Favorite Monitoring.
 */
class ComparisonService
{
    protected $countryService;
    protected $weatherService;
    protected $worldBankService;
    protected $exchangeRateService;
    protected $newsSentimentService;
    protected $riskScoringService;

    public function __construct(
        CountryService $countryService,
        WeatherService $weatherService,
        WorldBankService $worldBankService,
        ExchangeRateService $exchangeRateService,
        NewsSentimentService $newsSentimentService,
        RiskScoringService $riskScoringService
    ) {
        $this->countryService = $countryService;
        $this->weatherService = $weatherService;
        $this->worldBankService = $worldBankService;
        $this->exchangeRateService = $exchangeRateService;
        $this->newsSentimentService = $newsSentimentService;
        $this->riskScoringService = $riskScoringService;
    }

    /**
     * Mengambil profil intelijen lengkap untuk satu negara.
     * 
     * @param string $countryName Nama negara (contoh: "Indonesia", "Germany")
     * @return array|null Data lengkap atau null jika negara tidak ditemukan
     */
    public function getCountryIntelligence(string $countryName): ?array
    {
        // 1. Ambil data dasar negara dari CountryService
        $result = $this->countryService->getCountry($countryName);

        if (!$result || empty($result['data']['objects'])) {
            return null;
        }

        $country = $result['data']['objects'][0];
        $weather = null;
        $economy = null;
        $exchangeRate = null;
        $news = [];

        // 2. Ambil data cuaca satelit (Open-Meteo API)
        if (isset($country['coordinates']['lat'], $country['coordinates']['lng'])) {
            $lat = number_format((float) $country['coordinates']['lat'], 6, '.', '');
            $lng = number_format((float) $country['coordinates']['lng'], 6, '.', '');
            $weather = $this->weatherService->getCurrentWeather($lat, $lng);
        }

        // 3. Ambil data ekonomi makro (World Bank API)
        if (isset($country['codes']['alpha_2'])) {
            $economy = $this->worldBankService->getEconomyData($country['codes']['alpha_2']);
        }

        // 4. Ambil kurs mata uang (ExchangeRate API)
        $currencyCode = $country['currencies'][0]['code'] ?? null;
        if ($currencyCode) {
            $exchangeRate = $this->exchangeRateService->getExchangeRate($currencyCode);
        }

        // 5. Ambil berita & sentimen (News Sentiment API)
        $resolvedName = $country['names']['common'] ?? $countryName;
        $news = $this->newsSentimentService->getNewsWithSentiment($resolvedName);

        // 6. Kalkulasi skor risiko agregat (Weighted Risk Model)
        $riskData = $this->riskScoringService->calculateRisk($weather, $economy, $news);

        // 7. Susun payload respons
        return [
            'country'    => $resolvedName,
            'gdp'        => $economy['gdp'] ?? 'N/A',
            'inflation'  => $economy['inflation'] ?? 0,
            'currency'   => $exchangeRate ?? 'N/A',
            'currCode'   => $currencyCode ?? 'N/A',
            'weather'    => isset($weather['current']['temperature_2m'])
                            ? $weather['current']['temperature_2m'] . '°C' : 'N/A',
            'wind'       => isset($weather['current']['wind_speed_10m'])
                            ? $weather['current']['wind_speed_10m'] . ' km/h' : 'N/A',
            'risk'       => $riskData ?? [
                'score'     => 0,
                'status'    => 'N/A',
                'breakdown' => ['weather' => 0, 'news' => 0, 'inflation' => 0, 'currency' => 0],
            ],
        ];
    }

    /**
     * Membandingkan dua negara secara langsung.
     * 
     * @param string $countryA Nama negara pertama
     * @param string $countryB Nama negara kedua
     * @return array Hasil perbandingan lengkap
     */
    public function compareCountries(string $countryA, string $countryB): array
    {
        $dataA = $this->getCountryIntelligence($countryA);
        $dataB = $this->getCountryIntelligence($countryB);

        if (!$dataA || !$dataB) {
            return [
                'success' => false,
                'message' => 'Salah satu atau kedua negara tidak ditemukan.',
                'data'    => null,
            ];
        }

        // Hitung analisis perbandingan
        $riskDiff = abs($dataA['risk']['score'] - $dataB['risk']['score']);
        $saferCountry = $dataA['risk']['score'] <= $dataB['risk']['score']
                        ? $dataA['country'] : $dataB['country'];

        $inflationA = is_numeric($dataA['inflation']) ? (float) $dataA['inflation'] : null;
        $inflationB = is_numeric($dataB['inflation']) ? (float) $dataB['inflation'] : null;
        $betterInflation = null;
        if ($inflationA !== null && $inflationB !== null) {
            $betterInflation = $inflationA <= $inflationB ? $dataA['country'] : $dataB['country'];
        }

        return [
            'success'  => true,
            'message'  => 'Perbandingan berhasil.',
            'data'     => [
                'countryA'         => $dataA,
                'countryB'         => $dataB,
                'analysis'         => [
                    'risk_difference'  => $riskDiff,
                    'safer_country'    => $saferCountry,
                    'better_inflation' => $betterInflation,
                ],
            ],
        ];
    }
}
