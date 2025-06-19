<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\PackageModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $paketModel = new PackageModel();
        
        $data = [
            'total_users' => $userModel->countAll(),
            'total_packages' => $paketModel->countAll(),
            'latest_users' => $userModel->orderBy('created_at', 'DESC')->limit(5)->findAll()
        ];
        
        return view('admin/dashboard/index', $data);
    }
}
