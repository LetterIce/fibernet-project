<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminActivitiesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 5,
                'user_id' => 1,
                'activity_type' => 'registration',
                'description' => 'Pelanggan baru mendaftar - andi mendaftar paket Premium',
                'icon' => 'user-plus',
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 minutes')),
                'updated_at' => null
            ],
            [
                'id' => 6,
                'user_id' => 1,
                'activity_type' => 'package',
                'description' => 'Paket baru ditambahkan - Paket Ultra Speed 100Mbps',
                'icon' => 'box',
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 hour')),
                'updated_at' => null
            ],
            [
                'id' => 7,
                'user_id' => 1,
                'activity_type' => 'payment',
                'description' => 'Pembayaran diterima - Rp 365.000 dari pelanggan andi',
                'icon' => 'credit-card',
                'created_at' => date('Y-m-d H:i:s', strtotime('-3 hours')),
                'updated_at' => null
            ],
            [
                'id' => 8,
                'user_id' => 1,
                'activity_type' => 'system',
                'description' => 'Backup sistem berhasil dilakukan',
                'icon' => 'database',
                'created_at' => date('Y-m-d H:i:s', strtotime('-5 hours')),
                'updated_at' => null
            ],
            [
                'id' => 9,
                'user_id' => 1,
                'activity_type' => 'maintenance',
                'description' => 'Maintenance server selesai dilakukan',
                'icon' => 'tools',
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
                'updated_at' => null
            ]
        ];

        $this->db->table('activities')->insertBatch($data);
    }
}
