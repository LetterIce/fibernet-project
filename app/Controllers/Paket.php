<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PackageModel;
use CodeIgniter\HTTP\ResponseInterface;

class Paket extends BaseController
{
    public function index()
    {
        $packageModel = new PackageModel();
        $data = [
            'packages' => $packageModel->findAll(),
        ];
        return view('paket/index', $data);
    }
}
