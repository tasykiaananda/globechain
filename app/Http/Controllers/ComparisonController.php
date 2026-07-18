<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ComparisonService;
use Illuminate\Support\Facades\DB;

/**
 * ComparisonController
 * 
 * Controller untuk menangani fitur Country Comparison Engine
 * dan Favorite Monitoring List.
 * 
 * Endpoints:
 * - GET /tools/comparison          → Halaman Comparison Engine
 * - GET /tools/favorites           → Halaman Favorite Monitoring
 * - GET /api/compare?country=...   → API: Data intelijen satu negara
 * - GET /api/compare/dual          → API: Perbandingan dua negara sekaligus
 */
class ComparisonController extends Controller
{
    protected $comparisonService;

    public function __construct(ComparisonService $comparisonService)
    {
        $this->comparisonService = $comparisonService;
    }

    // ==========================================
    // HALAMAN VIEW
    // ==========================================

    /**
     * Halaman Country Comparison Engine
     */
    public function comparison()
    {
        $countriesList = DB::table('countries')->orderBy('name', 'asc')->pluck('name');
        return view('tools.comparison', compact('countriesList'));
    }

    /**
     * Halaman Favorite Monitoring List
     */
    public function favorites()
    {
        $countriesList = DB::table('countries')->orderBy('name', 'asc')->pluck('name');
        return view('tools.favorites', compact('countriesList'));
    }

    // ==========================================
    // API ENDPOINTS
    // ==========================================

    /**
     * API: Ambil data intelijen lengkap untuk satu negara.
     * 
     * GET /api/compare?country=Indonesia
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCountryData(Request $request)
    {
        $countryName = $request->query('country');

        if (!$countryName) {
            return response()->json([
                'success' => false,
                'message' => 'Parameter "country" wajib diisi.',
                'data'    => null,
            ], 400);
        }

        $data = $this->comparisonService->getCountryIntelligence($countryName);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => "Negara '{$countryName}' tidak ditemukan dalam database.",
                'data'    => null,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => "Data intelijen untuk {$data['country']} berhasil dimuat.",
            'data'    => $data,
        ]);
    }

    /**
     * API: Bandingkan dua negara sekaligus.
     * 
     * GET /api/compare/dual?countryA=Germany&countryB=Australia
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function compareDual(Request $request)
    {
        $countryA = $request->query('countryA');
        $countryB = $request->query('countryB');

        if (!$countryA || !$countryB) {
            return response()->json([
                'success' => false,
                'message' => 'Parameter "countryA" dan "countryB" wajib diisi.',
                'data'    => null,
            ], 400);
        }

        if ($countryA === $countryB) {
            return response()->json([
                'success' => false,
                'message' => 'Kedua negara harus berbeda untuk dibandingkan.',
                'data'    => null,
            ], 422);
        }

        $result = $this->comparisonService->compareCountries($countryA, $countryB);

        if (!$result['success']) {
            return response()->json($result, 404);
        }

        return response()->json($result);
    }

    /**
     * API: Ambil data ringkas untuk daftar favorit (batch).
     * 
     * GET /api/favorites/batch?countries[]=Indonesia&countries[]=Germany
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFavoritesBatch(Request $request)
    {
        $countries = $request->query('countries', []);

        if (empty($countries) || !is_array($countries)) {
            return response()->json([
                'success' => false,
                'message' => 'Parameter "countries[]" wajib diisi sebagai array.',
                'data'    => [],
            ], 400);
        }

        // Batasi maksimal 10 negara per batch untuk menjaga performa
        $countries = array_slice($countries, 0, 10);

        $results = [];
        foreach ($countries as $name) {
            $data = $this->comparisonService->getCountryIntelligence($name);
            if ($data) {
                $results[] = $data;
            }
        }

        return response()->json([
            'success' => true,
            'message' => count($results) . ' negara berhasil dimuat.',
            'data'    => $results,
        ]);
    }
}
