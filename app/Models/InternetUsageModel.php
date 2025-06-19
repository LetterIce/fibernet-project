<?php

namespace App\Models;

use CodeIgniter\Model;

class InternetUsageModel extends Model
{
    protected $table            = 'internet_usage';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'data_used_gb', 'month', 'year', 'created_at'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getCurrentMonthUsage($userId)
    {
        $currentMonth = date('n');
        $currentYear = date('Y');
        
        $result = $this->where('user_id', $userId)
                      ->where('month', $currentMonth)
                      ->where('year', $currentYear)
                      ->first();
                      
        return $result ? $result['data_used_gb'] : 0;
    }
    
    public function getPreviousMonthUsage($userId)
    {
        $previousMonth = date('n', strtotime('-1 month'));
        $previousYear = date('Y', strtotime('-1 month'));
        
        $result = $this->where('user_id', $userId)
                      ->where('month', $previousMonth)
                      ->where('year', $previousYear)
                      ->first();
                      
        return $result ? $result['data_used_gb'] : 0;
    }
    
    public function getLast30DaysUsage($userId)
    {
        return $this->where('user_id', $userId)
                   ->where('created_at >=', date('Y-m-d', strtotime('-30 days')))
                   ->orderBy('created_at', 'ASC')
                   ->findAll();
    }
}
