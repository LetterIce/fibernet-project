<?php namespace App\Controllers;

use App\Libraries\CoverageChecker; // Panggil library

class Area extends BaseController
{
    public function index()
    {
        return view('area/index'); // View berisi form input kode pos
    }

    public function proses()
    {
        $postalCode = $this->request->getPost('postal_code');
        
        $checker = new CoverageChecker(); // Buat instance library
        $isCovered = $checker->isCovered($postalCode);

        $message = $isCovered 
            ? "Selamat! Area dengan kode pos $postalCode sudah ter-cover layanan FiberNet."
            : "Mohon maaf, area dengan kode pos $postalCode belum ter-cover saat ini.";

        // Kirim pesan kembali ke view
        return redirect()->back()->with('message', $message);
    }
}