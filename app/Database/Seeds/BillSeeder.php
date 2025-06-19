<?php namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BillSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'user_id' => 2,
                'amount' => 299000.00,
                'due_date' => date('Y-m-d', strtotime('+5 days')),
                'status' => 'pending',
                'month' => date('n'),
                'year' => date('Y'),
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'user_id' => 2,
                'amount' => 299000.00,
                'due_date' => date('Y-m-d', strtotime('-25 days')),
                'status' => 'paid',
                'month' => date('n', strtotime('-1 month')),
                'year' => date('Y', strtotime('-1 month')),
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 month')),
            ],
        ];
        
        $this->db->table('bills')->insertBatch($data);
    }
}
