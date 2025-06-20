<?php namespace App\Controllers;

use App\Models\DashboardModel;
use App\Models\InternetUsageModel;
use App\Models\SpeedHistoryModel;
use App\Models\BillModel;
use App\Models\ActivityModel;

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
        
        // Get current bill
        $currentBill = $this->billModel->getCurrentBill($userId);
        
        // Get connection status
        $connectionStatus = $this->dashboardModel->getConnectionStatus($userId);
        
        // Get recent activities for current user only
        $recentActivities = $this->activityModel->where('user_id', $userId)
                                                ->orderBy('created_at', 'DESC')
                                                ->limit(10)
                                                ->findAll();
        
        $data = [
            'title' => 'Dashboard',
            'current_usage' => $currentUsage,
            'usage_percentage' => $usagePercentage,
            'last_30_days_usage' => $last30DaysUsage,
            'latest_speed' => $latestSpeed,
            'speed_history' => $speedHistory,
            'current_bill' => $currentBill,
            'connection_status' => $connectionStatus,
            'recent_activities' => $recentActivities
        ];
        
        return view('dashboard/index', $data);
    }
    
    private function calculateUsagePercentage($current, $previous)
    {
        if ($previous == 0) return 0;
        return round((($current - $previous) / $previous) * 100, 1);
    }
}