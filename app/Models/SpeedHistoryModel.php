<?php namespace App\Models;

use CodeIgniter\Model;

class SpeedHistoryModel extends Model
{
    protected $table = 'speed_history';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'download_speed', 'upload_speed', 'ping', 'tested_at'];
    protected $useTimestamps = true;
    
    public function getLatestSpeed($userId)
    {
        return $this->where('user_id', $userId)
                   ->orderBy('tested_at', 'DESC')
                   ->first();
    }
    
    public function getSpeedHistory($userId, $days = 30)
    {
        return $this->where('user_id', $userId)
                   ->where('tested_at >=', date('Y-m-d', strtotime("-{$days} days")))
                   ->orderBy('tested_at', 'ASC')
                   ->findAll();
    }
}
