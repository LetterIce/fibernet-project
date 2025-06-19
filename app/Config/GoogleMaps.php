<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

class GoogleMaps extends BaseConfig
{
    /**
     * Google Maps API Key
     * Get your API key from: https://console.cloud.google.com/
     * Required APIs: Maps JavaScript API, Geocoding API
     */
    public $apiKey = 'AIzaSyCobOKq3hzi-qHJfwJnajguWHykOfBDJCc';
    
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
}
