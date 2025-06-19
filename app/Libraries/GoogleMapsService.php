<?php namespace App\Libraries;

use Config\GoogleMaps;

class GoogleMapsService
{
    protected $config;
    
    public function __construct()
    {
        $this->config = new GoogleMaps();
    }
    
    /**
     * Get location details from coordinates using Google Geocoding API
     * @param float $lat
     * @param float $lng
     * @return array|null
     */
    public function getLocationFromCoordinates(float $lat, float $lng): ?array
    {
        $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng={$lat},{$lng}&key={$this->config->apiKey}";
        
        $response = file_get_contents($url);
        $data = json_decode($response, true);
        
        if ($data['status'] === 'OK' && !empty($data['results'])) {
            $result = $data['results'][0];
            
            return [
                'formatted_address' => $result['formatted_address'],
                'postal_code' => $this->extractPostalCode($result['address_components']),
                'city' => $this->extractCity($result['address_components']),
                'administrative_area' => $this->extractAdministrativeArea($result['address_components']),
                'coordinates' => [
                    'lat' => $lat,
                    'lng' => $lng
                ]
            ];
        }
        
        return null;
    }
    
    /**
     * Extract postal code from address components
     */
    private function extractPostalCode(array $components): ?string
    {
        foreach ($components as $component) {
            if (in_array('postal_code', $component['types'])) {
                return $component['long_name'];
            }
        }
        return null;
    }
    
    /**
     * Extract city from address components
     */
    private function extractCity(array $components): ?string
    {
        foreach ($components as $component) {
            if (in_array('administrative_area_level_2', $component['types'])) {
                return $component['long_name'];
            }
        }
        return null;
    }
    
    /**
     * Extract administrative area from address components
     */
    private function extractAdministrativeArea(array $components): ?string
    {
        foreach ($components as $component) {
            if (in_array('administrative_area_level_1', $component['types'])) {
                return $component['long_name'];
            }
        }
        return null;
    }
}
