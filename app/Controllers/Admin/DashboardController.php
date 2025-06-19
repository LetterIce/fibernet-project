<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\PackageModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $packageModel = new PackageModel();

        $data = [
            'total_users' => $userModel->where('role', 'user')->countAllResults(),
            'total_packages' => $packageModel->countAllResults(),
            'latest_users' => $userModel->where('role', 'user')->orderBy('created_at', 'DESC')->limit(5)->find(),
        ];
        
        return view('admin/dashboard/index', $data);
    }
}