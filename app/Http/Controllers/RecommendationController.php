<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\Category;
use App\Services\SAWCalculator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Throwable;

class RecommendationController extends Controller
{
    private const SUPPORTED_REGENCIES = [
        'Lombok Barat',
        'Lombok Tengah',
        'Lombok Timur',
        'Lombok Utara',
    ];

    /**
     * Default center coordinates for each supported regency.
     * Used as fallback when GPS/IP location is unavailable.
     */
    private const REGION_CENTERS = [
        'Lombok Barat'  => ['lat' => -8.6500, 'lng' => 116.0800], 
        'Lombok Tengah' => ['lat' => -8.7200, 'lng' => 116.2700],
        'Lombok Timur'  => ['lat' => -8.6500, 'lng' => 116.5400],
        'Lombok Utara'  => ['lat' => -8.3500, 'lng' => 116.1600],
    ];

    /**
     * Show recommendation form with filter preferences
     */
    public function index(Request $request)
    {
        // Get filter values from request (if exists)
        $filters = [
            'max_budget' => $request->input('max_budget'),
            'max_distance' => $request->input('max_distance'),
            'facilities' => $request->input('facilities', []),
            'min_rating' => $request->input('min_rating'),
            'category_id' => $request->input('category_id'),
            'user_lat' => $request->input('user_lat'),
            'user_lng' => $request->input('user_lng'),
            'user_regency' => $this->normalizeRegency($request->input('user_regency')),
            'location_source' => $this->normalizeLocationSource($request->input('location_source')),
            'selected_region' => $request->input('selected_region'),
        ];

        if ($this->hasValidCoordinates($filters['user_lat'], $filters['user_lng'])) {
            $filters['user_lat'] = round((float) $filters['user_lat'], 8);
            $filters['user_lng'] = round((float) $filters['user_lng'], 8);

            if (empty($filters['user_regency'])) {
                $filters['user_regency'] = $this->resolveRegencyFromCoordinates($filters['user_lat'], $filters['user_lng']);
            }

            $request->session()->put('recommendation_user_location', [
                'latitude' => $filters['user_lat'],
                'longitude' => $filters['user_lng'],
                'regency' => $filters['user_regency'],
                'source' => $filters['location_source'],
            ]);
        } else {
            // Fallback: if no valid GPS/IP coordinates, check for manual region selection
            $selectedRegion = $filters['selected_region'] ?? null;

            if ($selectedRegion && isset(self::REGION_CENTERS[$selectedRegion])) {
                $center = self::REGION_CENTERS[$selectedRegion];
                $filters['user_lat'] = $center['lat'];
                $filters['user_lng'] = $center['lng'];
                $filters['user_regency'] = $selectedRegion;
                $filters['location_source'] = 'manual';

                $request->session()->put('recommendation_user_location', [
                    'latitude' => $center['lat'],
                    'longitude' => $center['lng'],
                    'regency' => $selectedRegion,
                    'source' => 'manual',
                ]);
            } else {
                unset($filters['user_lat'], $filters['user_lng'], $filters['user_regency'], $filters['location_source']);
            }
        }

        // Remove null/empty values
        $filters = array_filter($filters, function ($value) {
            if (is_array($value)) {
                return !empty($value);
            }

            if (is_string($value)) {
                return trim($value) !== '';
            }

            return !is_null($value);
        });

        $criterias = Criteria::with('weight')->get();
        $categories = Category::all();
        $hasFilters = !empty($filters);
        $result = null;

        // If there are filters, calculate SAW with filters
        if ($hasFilters) {
            $result = SAWCalculator::getDetails($filters);
        }

        return view('saw.recommendations.index', compact(
            'criterias',
            'categories',
            'filters',
            'hasFilters',
            'result'
        ));
    }

    /**
     * Reset filters and show all recommendations
     */
    public function reset(Request $request)
    {
        $request->session()->forget('recommendation_user_location');

        return redirect()->route('saw.recommendations.index');
    }

    private function hasValidCoordinates($lat, $lng): bool
    {
        if (!is_numeric($lat) || !is_numeric($lng)) {
            return false;
        }

        $lat = (float) $lat;
        $lng = (float) $lng;

        return $lat >= -90 && $lat <= 90 && $lng >= -180 && $lng <= 180;
    }

    private function normalizeLocationSource(?string $source): ?string
    {
        return in_array($source, ['gps', 'ip', 'manual'], true) ? $source : null;
    }

    private function resolveRegencyFromCoordinates(float $lat, float $lng): ?string
    {
        try {
            $response = Http::timeout(4)
                ->withHeaders([
                    'User-Agent' => config('app.name', 'GOlombok') . ' recommendation geocoder',
                ])
                ->get('https://nominatim.openstreetmap.org/reverse', [
                    'format' => 'jsonv2',
                    'lat' => $lat,
                    'lon' => $lng,
                    'zoom' => 10,
                    'addressdetails' => 1,
                    'accept-language' => 'id',
                ]);

            if (!$response->successful()) {
                return null;
            }

            $data = $response->json();
            $address = $data['address'] ?? [];
            $candidates = [
                $address['county'] ?? null,
                $address['city'] ?? null,
                $address['municipality'] ?? null,
                $address['state_district'] ?? null,
                $address['region'] ?? null,
                $data['display_name'] ?? null,
            ];

            foreach ($candidates as $candidate) {
                $regency = $this->normalizeRegency($candidate);

                if ($regency) {
                    return $regency;
                }
            }
        } catch (Throwable) {
            return null;
        }

        return null;
    }

    private function normalizeRegency(?string $value): ?string
    {
        if (!$value) {
            return null;
        }

        $normalized = strtolower($value);

        foreach (self::SUPPORTED_REGENCIES as $regency) {
            $needle = strtolower(str_replace(['Kabupaten ', 'Kota '], '', $regency));

            if (str_contains($normalized, $needle)) {
                return $regency;
            }
        }

        if (str_contains($normalized, 'mataram')) {
            return 'Kota Mataram';
        }

        return null;
    }

    /**
     * Get available region centers for the view.
     */
    public static function getRegionCenters(): array
    {
        return self::REGION_CENTERS;
    }
}
