<?php

namespace App\Controllers;

use App\Models\PackageModel;

class Paket extends BaseController
{
    public function index()
    {
        $packageModel = new PackageModel();
        
        $data = [
            'packages' => $packageModel->findAll()
        ];
        
        return view('paket/index', $data);
    }
}
