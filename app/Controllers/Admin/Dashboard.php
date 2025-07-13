<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\PackageModel;
use App\Models\ActivityModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $paketModel = new PackageModel();
        $activityModel = new ActivityModel();
        
        // Get customer registration statistics by month
        $registrationStats = $this->getRegistrationStatistics($userModel);
        
        // Format registration data for Chart.js
        $userRegistrationData = $this->formatRegistrationDataForChart($registrationStats);
        
        // Get package popularity data
        $packagePopularityData = $this->getPackagePopularityData($paketModel);
        
        // Get current user ID from session
        $currentUserId = (int)(session()->get('user_id') ?? 1);
        
        // Get recent activities for current user using the ActivityModel
        $recentActivities = $activityModel->getActivitiesByUserId($currentUserId, 8);
        
        $data = [
            'total_users' => $userModel->where('role', 'user')->countAllResults(),
            'total_packages' => $paketModel->countAll(),
            'active_users' => $userModel->where('role', 'user')->countAllResults(),
            'subscribers' => $userModel->where('subscribe_plan_id IS NOT NULL')->countAllResults(),
            'new_users_this_month' => $userModel->where('DATE_FORMAT(created_at, "%Y-%m") = DATE_FORMAT(NOW(), "%Y-%m")')->countAllResults(),
            'latest_users' => $userModel->orderBy('created_at', 'DESC')->limit(6)->findAll(),
            'recent_users' => $userModel->select('users.*, packages.name as package_name')
                                      ->join('packages', 'packages.id = users.subscribe_plan_id', 'left')
                                      ->orderBy('users.created_at', 'DESC')
                                      ->limit(5)
                                      ->findAll(),
            'user_registration_data' => $userRegistrationData,
            'package_popularity_data' => $packagePopularityData,
            'latest_activities' => $recentActivities,
            'recent_activities' => $recentActivities,
            'total_orders' => 0, // Placeholder for future orders functionality
            'total_revenue' => 0, // Placeholder for future revenue functionality
            'debug_user_id' => $currentUserId
        ];
        
        return view('admin/dashboard/index', $data);
    }
    
    public function updateUserPackage($userId)
    {
        $userModel = new UserModel();
        $packageModel = new PackageModel();
        
        $packageId = $this->request->getPost('package_id');
        
        $user = $userModel->find($userId);
        if (!$user) {
            return $this->response->setJSON(['success' => false, 'message' => 'User tidak ditemukan']);
        }

        // Validate package exists if not empty
        $package = null;
        if (!empty($packageId)) {
            $package = $packageModel->find($packageId);
            if (!$package) {
                return $this->response->setJSON(['success' => false, 'message' => 'Paket tidak ditemukan']);
            }
        }

        // Update user's package
        $updateData = [
            'subscribe_plan_id' => empty($packageId) ? null : $packageId,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        if ($userModel->update($userId, $updateData)) {
            $packageName = empty($packageId) ? 'dihapus' : $package['name'];
            return $this->response->setJSON([
                'success' => true, 
                'message' => "Paket berhasil diperbarui ke: {$packageName}"
            ]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal memperbarui paket']);
        }
    }
    
    private function getRegistrationStatistics($userModel)
    {
        // Get registration count by month for the current year
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        
        $stats = $builder->select("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count")
                        ->where('role', 'user') // Only count regular users, not admins
                        ->where('YEAR(created_at)', date('Y')) // Current year only
                        ->groupBy("DATE_FORMAT(created_at, '%Y-%m')")
                        ->orderBy('month', 'ASC')
                        ->get()
                        ->getResultArray();
        
        return $stats;
    }
    
    private function formatRegistrationDataForChart($stats)
    {
        $labels = [];
        $data = [];
        
        if (empty($stats)) {
            return [
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                'data' => [0, 0, 0, 0, 0, 0]
            ];
        }
        
        $months = [
            '01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr',
            '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug',
            '09' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec'
        ];
        
        foreach ($stats as $stat) {
            $monthNum = substr($stat['month'], -2);
            $labels[] = $months[$monthNum] ?? $monthNum;
            $data[] = (int)$stat['count'];
        }
        
        return [
            'labels' => $labels,
            'data' => $data
        ];
    }
    
    private function getPackagePopularityData($paketModel)
    {
        // Get package subscription counts from users table
        $db = \Config\Database::connect();
        $builder = $db->table('users u');
        
        $subscriptionStats = $builder->select('u.subscribe_plan_id, p.name, COUNT(*) as subscriber_count')
                                   ->join('packages p', 'p.id = u.subscribe_plan_id', 'left')
                                   ->where('u.role', 'user')
                                   ->where('u.subscribe_plan_id >', 0) // Exclude users with no subscription
                                   ->groupBy('u.subscribe_plan_id, p.name')
                                   ->orderBy('subscriber_count', 'DESC')
                                   ->get()
                                   ->getResultArray();
        
        if (empty($subscriptionStats)) {
            return [
                'labels' => ['Belum Ada Langganan'],
                'data' => [1],
                'colors' => ['#9ca3af']
            ];
        }
        
        $labels = [];
        $data = [];
        $colors = ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4', '#84cc16'];
        
        foreach ($subscriptionStats as $index => $stat) {
            $labels[] = $stat['name'] ?? 'Package ' . $stat['subscribe_plan_id'];
            $data[] = (int)$stat['subscriber_count'];
        }
        
        return [
            'labels' => $labels,
            'data' => $data,
            'colors' => array_slice($colors, 0, count($labels))
        ];
    }
}
