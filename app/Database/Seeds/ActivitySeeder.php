<?php namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ActivitySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'user_id' => 2,
                'activity_type' => 'payment',
                'description' => 'Pembayaran berhasil diproses',
                'icon' => 'check-circle',
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 hours')),
            ],
            [
                'user_id' => 2,
                'activity_type' => 'usage',
                'description' => 'Penggunaan data mencapai 50%',
                'icon' => 'bar-chart',
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
            ],
            [
                'user_id' => 2,
                'activity_type' => 'maintenance',
                'description' => 'Maintenance dijadwalkan',
                'icon' => 'tools',
                'created_at' => date('Y-m-d H:i:s', strtotime('-3 days')),
            ],
            [
                'user_id' => 2,
                'activity_type' => 'promo',
                'description' => 'Promo upgrade tersedia',
                'icon' => 'gift',
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 week')),
            ],
        ];
        
        $this->db->table('activities')->insertBatch($data);
    }
}
