<?php namespace App\Controllers;

use App\Models\DashboardModel;
use App\Models\InternetUsageModel;
use App\Models\SpeedHistoryModel;
use App\Models\BillModel;
use App\Models\ActivityModel;
use App\Models\UserModel;
use App\Models\PackageModel;

class Dashboard extends BaseController
{
    protected $dashboardModel;
    protected $usageModel;
    protected $speedModel;
    protected $billModel;
    protected $activityModel;

    public function __construct()
    {
        $this->dashboardModel = new DashboardModel();
        $this->usageModel = new InternetUsageModel();
        $this->speedModel = new SpeedHistoryModel();
        $this->billModel = new BillModel();
        $this->activityModel = new ActivityModel();
    }

    public function index()
    {
        $userId = session()->get('user_id');
        
        if (!$userId) {
            return redirect()->to('/login');
        }

        // Get current month usage
        $currentUsage = $this->usageModel->getCurrentMonthUsage($userId);
        $previousUsage = $this->usageModel->getPreviousMonthUsage($userId);
        $usagePercentage = $this->calculateUsagePercentage($currentUsage, $previousUsage);
        
        // Get last 30 days usage data
        $last30DaysUsage = $this->usageModel->getLast30DaysUsage($userId);
        
        // Get latest speed
        $latestSpeed = $this->speedModel->getLatestSpeed($userId);
        
        // Get speed history for chart
        $speedHistory = $this->speedModel->getSpeedHistory($userId, 30);
        
        // Get current pending bill
        $currentBill = $this->billModel->where([
            'user_id' => $userId,
            'month' => date('n'),
            'year' => date('Y'),
            'status' => 'pending'
        ])->first();
        
        // Get connection status
        $connectionStatus = $this->dashboardModel->getConnectionStatus($userId);
        
        // Get recent activities for current user only
        $recentActivities = $this->activityModel->where('user_id', $userId)
                                                ->orderBy('created_at', 'DESC')
                                                ->limit(10)
                                                ->findAll();

        // Get current user's package information
        $userModel = new UserModel();
        $packageModel = new PackageModel();
        
        $user = $userModel->find($userId);
        $currentPackage = null;
        
        if ($user) {
            // Try different possible column names for package reference
            $packageId = null;
            if (isset($user['package_id'])) {
                $packageId = $user['package_id'];
            } elseif (isset($user['subscribe_plan_id'])) {
                $packageId = $user['subscribe_plan_id'];
            } elseif (isset($user['plan_id'])) {
                $packageId = $user['plan_id'];
            }
            
            if ($packageId) {
                $currentPackage = $packageModel->find($packageId);
                // Update session with current package ID for upgrade functionality
                session()->set('user_package_id', $packageId);
            }
        }
        
        $data = [
            'title' => 'Dashboard',
            'current_usage' => $currentUsage,
            'usage_percentage' => $usagePercentage,
            'last_30_days_usage' => $last30DaysUsage,
            'latest_speed' => $latestSpeed,
            'speed_history' => $speedHistory,
            'current_bill' => $currentBill,
            'connection_status' => $connectionStatus,
            'recent_activities' => $recentActivities,
            'current_package' => $currentPackage,
            'user' => $user
        ];
        
        return view('dashboard/index', $data);
    }
    
    private function calculateUsagePercentage($current, $previous)
    {
        if ($previous == 0) return 0;
        return round((($current - $previous) / $previous) * 100, 1);
    }

    public function availablePackages()
    {
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unauthorized'
            ]);
        }
        
        $packageModel = new PackageModel();
        $packages = $packageModel->getAvailablePackages();
        $currentPackageId = session()->get('user_package_id');
        
        return $this->response->setJSON([
            'status' => 'success',
            'packages' => $packages,
            'current_package_id' => $currentPackageId
        ]);
    }

    public function upgradePackage()
    {
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unauthorized'
            ]);
        }
        
        $packageId = $this->request->getPost('package_id');
        $userId = session()->get('user_id');
        
        if (!$packageId) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Package ID is required'
            ]);
        }
        
        $packageModel = new PackageModel();
        $userModel = new UserModel();
        $billModel = new BillModel();
        
        // Validate package exists
        $package = $packageModel->getPackageById($packageId);
        if (!$package) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Package not found'
            ]);
        }
        
        // Check if user is upgrading to a different package
        $currentUser = $userModel->find($userId);
        $currentPackageId = $currentUser['subscribe_plan_id'] ?? null;
        
        if ($currentPackageId == $packageId) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Anda sudah menggunakan paket ini.'
            ]);
        }
        
        // Start database transaction
        $db = \Config\Database::connect();
        $db->transStart();
        
        try {
            // Update user's package
            $updateData = [
                'subscribe_plan_id' => $packageId,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            if (!$userModel->update($userId, $updateData)) {
                throw new \Exception('Failed to update user package');
            }
            
            // Create new bill for the upgraded package
            $currentMonth = date('n'); // 1-12
            $currentYear = date('Y');
            $nextMonth = $currentMonth + 1;
            $nextYear = $currentYear;
            
            // Handle year rollover
            if ($nextMonth > 12) {
                $nextMonth = 1;
                $nextYear++;
            }
            
            // Set due date to the 25th of next month
            $dueDate = date('Y-m-d', mktime(0, 0, 0, $nextMonth, 25, $nextYear));
            
            // Check if bill for next month already exists
            $existingBill = $billModel->where('user_id', $userId)
                                      ->where('month', $nextMonth)
                                      ->where('year', $nextYear)
                                      ->first();
            
            if ($existingBill) {
                // Update existing bill with new package price
                $billModel->update($existingBill['id'], [
                    'amount' => $package['price'],
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            } else {
                // Create new bill entry
                $billData = [
                    'user_id' => $userId,
                    'amount' => $package['price'],
                    'due_date' => $dueDate,
                    'status' => 'pending',
                    'month' => $nextMonth,
                    'year' => $nextYear,
                    'created_at' => date('Y-m-d H:i:s')
                ];
                
                if (!$billModel->insert($billData)) {
                    throw new \Exception('Failed to create new bill');
                }
            }
            
            // Complete transaction
            $db->transComplete();
            
            if ($db->transStatus() === false) {
                throw new \Exception('Transaction failed');
            }
            
            // Update session data
            session()->set('user_package_id', $packageId);
            
            // Log activity if ActivityModel exists
            if (class_exists('App\Models\ActivityModel')) {
                try {
                    $activityModel = new \App\Models\ActivityModel();
                    $allowedFields = $activityModel->getAllowedFields();
                    
                    $activityData = [
                        'user_id' => $userId,
                        'description' => "Upgraded to package: {$package['name']} - New bill created for " . date('F Y', mktime(0, 0, 0, $nextMonth, 1, $nextYear)),
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                    
                    if (in_array('icon', $allowedFields)) {
                        $activityData['icon'] = 'arrow-up';
                    }
                    
                    $activityModel->insert($activityData);
                } catch (\Exception $e) {
                    log_message('error', 'Failed to log activity: ' . $e->getMessage());
                }
            }
            
            return $this->response->setJSON([
                'status' => 'success',
                'message' => "Berhasil upgrade ke paket {$package['name']}! Tagihan baru sebesar Rp " . number_format($package['price'], 0, ',', '.') . " telah dibuat untuk periode " . date('F Y', mktime(0, 0, 0, $nextMonth, 1, $nextYear)) . "."
            ]);
            
        } catch (\Exception $e) {
            // Rollback transaction on error
            $db->transRollback();
            
            log_message('error', 'Package upgrade failed: ' . $e->getMessage());
            
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal mengupgrade paket. Silakan coba lagi.'
            ]);
        }
    }
}