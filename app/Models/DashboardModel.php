<?php namespace App\Models;

use CodeIgniter\Model;

class DashboardModel extends Model
{
    public function getConnectionStatus($userId)
    {
        // Simulate connection status - in real app, this would check actual connection
        return [
            'status' => 'Online',
            'uptime' => '99.9%',
            'last_check' => date('Y-m-d H:i:s')
        ];
    }
}
