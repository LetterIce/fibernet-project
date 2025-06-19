<?php namespace App\Models;

use CodeIgniter\Model;

class BillModel extends Model
{
    protected $table = 'bills';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'amount', 'due_date', 'status', 'month', 'year'];
    protected $useTimestamps = true;
    
    public function getCurrentBill($userId)
    {
        $currentMonth = date('n');
        $currentYear = date('Y');
        
        return $this->where('user_id', $userId)
                   ->where('month', $currentMonth)
                   ->where('year', $currentYear)
                   ->first();
    }
    
    public function getDaysUntilDue($dueDate)
    {
        $today = new \DateTime();
        $due = new \DateTime($dueDate);
        $diff = $today->diff($due);
        return $diff->days;
    }
}
