<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

class GoogleMaps extends BaseConfig
{
    /**
     * Google Maps API Key
     * Get your API key from: https://console.cloud.google.com/
     * Required APIs: Maps JavaScript API, Geocoding API
     */
    public $apiKey;
    
    /**
     * Default map center (Jakarta coordinates)
     */
    public $defaultCenter = [
        'lat' => -6.2088,
        'lng' => 106.8456
    ];
    
    /**
     * Default zoom level
     */
    public $defaultZoom = 13;

    public function __construct()
    {
        parent::__construct();
        
        // Load API key from environment variable
        $this->apiKey = env('GOOGLE_MAPS_API_KEY', '');
    }
}
