<?php namespace App\Libraries;

class CoverageChecker
{
    // Coverage areas with coordinates (polygon boundaries)
    protected $coveredAreas = [
        'jakarta_pusat' => [
            'name' => 'Jakarta Pusat',
            'postal_codes' => ['10110', '10120', '10130'],
            'boundaries' => [
                'north' => -6.1500,
                'south' => -6.2500,
                'east' => 106.8800,
                'west' => 106.8000
            ]
        ],
        'bandung' => [
            'name' => 'Bandung',
            'postal_codes' => ['40111', '40112', '40113'],
            'boundaries' => [
                'north' => -6.8500,
                'south' => -6.9500,
                'east' => 107.6500,
                'west' => 107.5500
            ]
        ],
        'surabaya' => [
            'name' => 'Surabaya',
            'postal_codes' => ['60111', '60112', '60113'],
            'boundaries' => [
                'north' => -7.2000,
                'south' => -7.3500,
                'east' => 112.8000,
                'west' => 112.7000
            ]
        ]
    ];

    /**
     * Check coverage by postal code (legacy method)
     */
    public function isCovered(string $postalCode): bool
    {
        foreach ($this->coveredAreas as $area) {
            if (in_array($postalCode, $area['postal_codes'])) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Check coverage by coordinates
     */
    public function isCoveredByCoordinates(float $lat, float $lng): array
    {
        foreach ($this->coveredAreas as $areaKey => $area) {
            if ($this->isWithinBoundaries($lat, $lng, $area['boundaries'])) {
                return [
                    'covered' => true,
                    'area' => $area['name'],
                    'area_key' => $areaKey
                ];
            }
        }
        
        return [
            'covered' => false,
            'area' => null,
            'area_key' => null
        ];
    }
    
    /**
     * Check if coordinates are within area boundaries
     */
    private function isWithinBoundaries(float $lat, float $lng, array $boundaries): bool
    {
        return $lat <= $boundaries['north'] && 
               $lat >= $boundaries['south'] && 
               $lng >= $boundaries['west'] && 
               $lng <= $boundaries['east'];
    }
    
    /**
     * Get all covered areas for map display
     */
    public function getAllCoveredAreas(): array
    {
        return $this->coveredAreas;
    }
}