<?php namespace App\Libraries;

class CoverageChecker
{
    // Daftar area yang ter-cover (bisa dari database di aplikasi nyata)
    protected $coveredAreas = [
        '10110', // Jakarta Pusat
        '40111', // Bandung
        '60111', // Surabaya
        '50111', // Semarang
    ];

    /**
     * Cek apakah kode pos ter-cover oleh layanan.
     * @param string $postalCode
     * @return bool
     */
    public function isCovered(string $postalCode): bool
    {
        return in_array($postalCode, $this->coveredAreas);
    }
}