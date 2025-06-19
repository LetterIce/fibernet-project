<?php namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SpeedHistorySeeder extends Seeder
{
    public function run()
    {
        $data = [];
        $userId = 2;
        
        // Generate 30 days of speed data
        for ($i = 30; $i >= 0; $i--) {
            $date = date('Y-m-d H:i:s', strtotime("-{$i} days"));
            $data[] = [
                'user_id' => $userId,
                'download_speed' => rand(95, 105) + (rand(0, 99) / 100),
                'upload_speed' => rand(45, 55) + (rand(0, 99) / 100),
                'ping' => rand(10, 25),
                'tested_at' => $date,
                'created_at' => $date,
            ];
        }
        
        $this->db->table('speed_history')->insertBatch($data);
    }
}
