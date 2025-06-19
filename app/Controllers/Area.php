<?php namespace App\Controllers;

use App\Libraries\CoverageChecker;
use App\Libraries\GoogleMapsService;

class Area extends BaseController
{
    public function index()
    {
        $checker = new CoverageChecker();
        
        $data = [
            'google_maps_api_key' => env('GOOGLE_MAPS_API_KEY', ''),
            'default_center' => [
                'lat' => -6.2088,
                'lng' => 106.8456
            ],
            'default_zoom' => 13,
            'covered_areas' => $checker->getAllCoveredAreas()
        ];
        
        return view('area/index', $data);
    }

    public function proses()
    {
        $postalCode = $this->request->getPost('postal_code');
        
        $checker = new CoverageChecker();
        $isCovered = $checker->isCovered($postalCode);

        $message = $isCovered 
            ? "Selamat! Area dengan kode pos $postalCode sudah ter-cover layanan FiberNet."
            : "Mohon maaf, area dengan kode pos $postalCode belum ter-cover saat ini.";

        return redirect()->back()->with('message', $message);
    }
    
    /**
     * Check coverage by coordinates (AJAX endpoint)
     */
    public function checkByCoordinates()
    {
        $lat = $this->request->getPost('lat');
        $lng = $this->request->getPost('lng');
        
        if (!$lat || !$lng) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Koordinat tidak valid'
            ]);
        }
        
        $googleMaps = new GoogleMapsService();
        $checker = new CoverageChecker();
        
        // Get location details from coordinates
        $locationData = $googleMaps->getLocationFromCoordinates((float)$lat, (float)$lng);
        
        if (!$locationData) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Tidak dapat mendapatkan informasi lokasi'
            ]);
        }
        
        // Check coverage
        $coverageResult = $checker->isCoveredByCoordinates((float)$lat, (float)$lng);
        
        $message = $coverageResult['covered'] 
            ? "Selamat! Lokasi di {$locationData['formatted_address']} sudah ter-cover layanan FiberNet."
            : "Mohon maaf, lokasi di {$locationData['formatted_address']} belum ter-cover saat ini.";
        
        return $this->response->setJSON([
            'success' => true,
            'covered' => $coverageResult['covered'],
            'message' => $message,
            'location' => $locationData,
            'area' => $coverageResult['area']
        ]);
    }
}