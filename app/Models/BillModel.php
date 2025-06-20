<?php namespace App\Models;

use CodeIgniter\Model;

class BillModel extends Model
{
    protected $table            = 'bills';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'amount',
        'due_date',
        'status',
        'month',
        'year',
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
        'amount' => 'required|numeric|greater_than[0]',
        'due_date' => 'required|valid_date',
        'status' => 'required|in_list[pending,paid,overdue,cancelled]',
        'month' => 'required|numeric|greater_than[0]|less_than[13]',
        'year' => 'required|numeric|greater_than[2020]'
    ];

    protected $validationMessages = [
        'user_id' => [
            'required' => 'User ID is required',
            'numeric' => 'User ID must be numeric'
        ],
        'amount' => [
            'required' => 'Amount is required',
            'numeric' => 'Amount must be numeric',
            'greater_than' => 'Amount must be greater than 0'
        ],
        'due_date' => [
            'required' => 'Due date is required',
            'valid_date' => 'Due date must be a valid date'
        ],
        'status' => [
            'required' => 'Status is required',
            'in_list' => 'Status must be pending, paid, overdue, or cancelled'
        ],
        'month' => [
            'required' => 'Month is required',
            'numeric' => 'Month must be numeric',
            'greater_than' => 'Month must be between 1-12',
            'less_than' => 'Month must be between 1-12'
        ],
        'year' => [
            'required' => 'Year is required',
            'numeric' => 'Year must be numeric',
            'greater_than' => 'Year must be greater than 2020'
        ]
    ];

    protected $skipValidation = false;

    public function getCurrentBill($userId)
    {
        $currentMonth = date('n');
        $currentYear = date('Y');
        
        return $this->where('user_id', $userId)
                    ->where('month', $currentMonth)
                    ->where('year', $currentYear)
                    ->first();
    }

    public function getUserBills($userId, $limit = null)
    {
        $query = $this->where('user_id', $userId)
                      ->orderBy('year', 'DESC')
                      ->orderBy('month', 'DESC');
        
        if ($limit) {
            $query->limit($limit);
        }
        
        return $query->findAll();
    }

    public function getPendingBills($userId = null)
    {
        $query = $this->where('status', 'pending');
        
        if ($userId) {
            $query->where('user_id', $userId);
        }
        
        return $query->orderBy('due_date', 'ASC')->findAll();
    }

    public function getOverdueBills($userId = null)
    {
        $today = date('Y-m-d');
        $query = $this->where('status', 'pending')
                      ->where('due_date <', $today);
        
        if ($userId) {
            $query->where('user_id', $userId);
        }
        
        return $query->orderBy('due_date', 'ASC')->findAll();
    }

    public function markAsPaid($billId)
    {
        return $this->update($billId, [
            'status' => 'paid',
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function createMonthlyBill($userId, $packagePrice, $targetMonth = null, $targetYear = null)
    {
        // Default to next month if not specified
        if (!$targetMonth || !$targetYear) {
            $targetMonth = date('n') + 1;
            $targetYear = date('Y');
            
            if ($targetMonth > 12) {
                $targetMonth = 1;
                $targetYear++;
            }
        }
        
        // Check if bill already exists
        $existingBill = $this->where('user_id', $userId)
                             ->where('month', $targetMonth)
                             ->where('year', $targetYear)
                             ->first();
        
        if ($existingBill) {
            return false; // Bill already exists
        }
        
        // Set due date to 25th of the target month
        $dueDate = date('Y-m-d', mktime(0, 0, 0, $targetMonth, 25, $targetYear));
        
        $billData = [
            'user_id' => $userId,
            'amount' => $packagePrice,
            'due_date' => $dueDate,
            'status' => 'pending',
            'month' => $targetMonth,
            'year' => $targetYear,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        return $this->insert($billData);
    }

    public function getBillsByStatus($status, $limit = null)
    {
        $query = $this->select('bills.*, users.name as user_name, users.email as user_email')
                      ->join('users', 'users.id = bills.user_id', 'left')
                      ->where('bills.status', $status)
                      ->orderBy('bills.due_date', 'ASC');
        
        if ($limit) {
            $query->limit($limit);
        }
        
        return $query->findAll();
    }

    public function getTotalRevenue($month = null, $year = null)
    {
        $query = $this->selectSum('amount', 'total_revenue')
                      ->where('status', 'paid');
        
        if ($month) {
            $query->where('month', $month);
        }
        
        if ($year) {
            $query->where('year', $year);
        }
        
        $result = $query->get()->getRow();
        return $result ? $result->total_revenue : 0;
    }

    public function updateOverdueBills()
    {
        $today = date('Y-m-d');
        
        return $this->set('status', 'overdue')
                    ->where('status', 'pending')
                    ->where('due_date <', $today)
                    ->update();
    }
}
