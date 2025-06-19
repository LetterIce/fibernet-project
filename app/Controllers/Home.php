<?php

namespace App\Controllers;

use App\Models\PackageModel;

class Home extends BaseController
{
    public function index()
    {
        $packageModel = new PackageModel();
        
        $data = [
            'packages' => $packageModel->findAll()
        ];
        
        return view('home/index', $data);
    }
}
