<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\PackageModel;

class AdminController extends BaseController
{
    protected $userModel;
    protected $packageModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->packageModel = new PackageModel();
    }

    public function dashboard()
    {
        // Initialize default data first
        $data = [
            'total_users' => 0,
            'total_packages' => 0,
            'total_orders' => 0,
            'total_revenue' => 0,
            'latest_users' => [],
            'user_registration_data' => [
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                'data' => [0, 0, 0, 0, 0, 0]
            ],
            'package_popularity_data' => [
                'labels' => ['No Data'],
                'data' => [1],
                'colors' => ['#9ca3af']
            ]
        ];

        try {
            // Get total counts
            $data['total_users'] = $this->userModel->where('role', 'user')->countAllResults();
            $data['total_packages'] = $this->packageModel->where('is_active', 1)->countAllResults();
            
            // Get latest users (only role 'user')
            $data['latest_users'] = $this->userModel
                ->where('role', 'user')
                ->where('created_at IS NOT NULL')
                ->orderBy('created_at', 'DESC')
                ->limit(5)
                ->findAll();

            // Get user registration data
            $data['user_registration_data'] = $this->getUserRegistrationData();
            
            // Get package popularity data
            $data['package_popularity_data'] = $this->getPackagePopularityData();

        } catch (\Exception $e) {
            log_message('error', 'Dashboard error: ' . $e->getMessage());
            // Keep default data if there's an error
        }

        return view('admin/dashboard/index', $data);
    }

    private function getUserRegistrationData()
    {
        try {
            $months = [];
            $counts = [];
            
            // Get last 6 months
            for ($i = 5; $i >= 0; $i--) {
                $date = date('Y-m-01', strtotime("-$i months"));
                $month_name = date('M', strtotime($date));
                $next_month = date('Y-m-01', strtotime('+1 month', strtotime($date)));
                
                $count = $this->userModel
                    ->where('role', 'user')
                    ->where('created_at IS NOT NULL')
                    ->where('created_at >=', $date)
                    ->where('created_at <', $next_month)
                    ->countAllResults();
                
                $months[] = $month_name;
                $counts[] = $count;
            }
            
            return [
                'labels' => $months,
                'data' => $counts
            ];
        } catch (\Exception $e) {
            return [
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                'data' => [0, 0, 0, 0, 0, 0]
            ];
        }
    }

    private function getPackagePopularityData()
    {
        try {
            $packages = $this->packageModel
                ->select('name, subscribers')
                ->where('is_active', 1)
                ->orderBy('subscribers', 'DESC')
                ->limit(5)
                ->findAll();
            
            if (empty($packages)) {
                return [
                    'labels' => ['No Data'],
                    'data' => [1],
                    'colors' => ['#9ca3af']
                ];
            }
            
            $labels = [];
            $data = [];
            $colors = ['#3b82f6', '#10b981', '#8b5cf6', '#f59e0b', '#ef4444'];
            
            foreach ($packages as $index => $package) {
                $labels[] = $package['name'];
                $data[] = (int)$package['subscribers'];
            }
            
            return [
                'labels' => $labels,
                'data' => $data,
                'colors' => array_slice($colors, 0, count($labels))
            ];
        } catch (\Exception $e) {
            return [
                'labels' => ['No Data'],
                'data' => [1],
                'colors' => ['#9ca3af']
            ];
        }
    }
}
