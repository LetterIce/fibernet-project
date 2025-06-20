<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivityModel extends Model
{
    protected $table            = 'activities';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'description',
        'icon',
        'created_at',
        'updated_at'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'user_id' => 'required|numeric',
        'description' => 'required|min_length[3]|max_length[500]'
    ];

    protected $validationMessages = [
        'user_id' => [
            'required' => 'User ID is required',
            'numeric' => 'User ID must be numeric'
        ],
        'description' => [
            'required' => 'Description is required',
            'min_length' => 'Description must be at least 3 characters',
            'max_length' => 'Description cannot exceed 500 characters'
        ]
    ];

    protected $skipValidation = false;

    public function getUserActivities($userId, $limit = 10)
    {
        return $this->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    public function getRecentActivities($limit = 50)
    {
        return $this->select('activities.*, users.name as user_name')
                    ->join('users', 'users.id = activities.user_id', 'left')
                    ->orderBy('activities.created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    public function logActivity($userId, $description, $icon = 'info-circle')
    {
        return $this->insert([
            'user_id' => $userId,
            'description' => $description,
            'icon' => $icon,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}
