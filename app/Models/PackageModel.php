<?php

namespace App\Models;

use CodeIgniter\Model;

class PackageModel extends Model
{
    protected $table            = 'packages';
    protected $primaryKey        = 'id';
    protected $useAutoIncrement  = true;
    protected $returnType        = 'array';
    protected $useSoftDeletes    = false;
    protected $protectFields     = true;
    protected $allowedFields     = [
        'name',
        'speed',
        'price',
        'description',
        'popular',
        'features',
        'created_at',
        'updated_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[255]',
        'speed' => 'required|numeric|greater_than[0]',
        'price' => 'required|numeric|greater_than[0]',
        'description' => 'permit_empty|max_length[1000]',
        'popular' => 'permit_empty|in_list[true,false]'
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Nama paket harus diisi',
            'min_length' => 'Nama paket minimal 3 karakter',
            'max_length' => 'Nama paket maksimal 255 karakter'
        ],
        'speed' => [
            'required' => 'Kecepatan harus diisi',
            'numeric' => 'Kecepatan harus berupa angka',
            'greater_than' => 'Kecepatan harus lebih dari 0'
        ],
        'price' => [
            'required' => 'Harga harus diisi',
            'numeric' => 'Harga harus berupa angka',
            'greater_than' => 'Harga harus lebih dari 0'
        ],
        'description' => [
            'max_length' => 'Deskripsi tidak boleh lebih dari 1000 karakter'
        ],
        'popular' => [
            'in_list' => 'Status popular harus true atau false'
        ]
    ];

    protected $skipValidation = false;

    // Override the update method to add logging for debugging
    public function update($id = null, $data = null): bool
    {
        // Log the update attempt
        log_message('debug', 'PackageModel update called with ID: ' . $id . ' and data: ' . json_encode($data));
        
        $result = parent::update($id, $data);
        
        if (!$result) {
            log_message('error', 'PackageModel update failed. Errors: ' . json_encode($this->errors()));
        } else {
            log_message('debug', 'PackageModel update successful for ID: ' . $id);
        }
        
        return $result;
    }

    // Custom methods for specific queries
    public function getPopularPackages()
    {
        return $this->where('popular', 'true')->findAll();
    }

    public function getActivePackages()
    {
        return $this->findAll(); // Assuming all packages are active unless specified otherwise
    }

    public function searchPackages($keyword)
    {
        return $this->like('name', $keyword)
                    ->orLike('description', $keyword)
                    ->findAll();
    }

    public function getPackagesBySpeed($minSpeed = null, $maxSpeed = null)
    {
        $builder = $this->builder();
        
        if ($minSpeed !== null) {
            $builder->where('speed >=', $minSpeed);
        }
        
        if ($maxSpeed !== null) {
            $builder->where('speed <=', $maxSpeed);
        }
        
        return $builder->get()->getResultArray();
    }

    public function getPackagesByPriceRange($minPrice = null, $maxPrice = null)
    {
        $builder = $this->builder();
        
        if ($minPrice !== null) {
            $builder->where('price >=', $minPrice);
        }
        
        if ($maxPrice !== null) {
            $builder->where('price <=', $maxPrice);
        }
        
        return $builder->get()->getResultArray();
    }

    public function getPackageStatistics($packageId)
    {
        $db = \Config\Database::connect();
        
        // Get total subscribers for this package (excluding admin role)
        $totalSubscribers = $db->table('users')
            ->where('subscribe_plan_id', $packageId)
            ->where('role !=', 'admin')
            ->countAllResults();
        
        // Get monthly revenue from bills for users subscribed to this package
        $monthlyRevenue = $db->table('bills b')
            ->join('users u', 'b.user_id = u.id')
            ->where('u.subscribe_plan_id', $packageId)
            ->where('u.role !=', 'admin')
            ->where('b.month', date('n')) // Current month
            ->where('b.year', date('Y'))  // Current year
            ->selectSum('b.amount', 'total_revenue')
            ->get()
            ->getRow()
            ->total_revenue ?? 0;
        
        return [
            'total_subscribers' => $totalSubscribers,
            'monthly_revenue' => $monthlyRevenue
        ];
    }
}
