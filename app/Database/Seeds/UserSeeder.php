<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // First, update existing users with created_at if NULL
        $this->db->query("UPDATE users SET created_at = NOW(), updated_at = NOW() WHERE created_at IS NULL");
        
        // Sample users data
        $users = [
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@gmail.com',
                'password_hash' => password_hash('password123', PASSWORD_DEFAULT),
                'role' => 'user',
                'created_at' => date('Y-m-d H:i:s', strtotime('-45 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-45 days'))
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti@gmail.com',
                'password_hash' => password_hash('password123', PASSWORD_DEFAULT),
                'role' => 'user',
                'created_at' => date('Y-m-d H:i:s', strtotime('-38 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-38 days'))
            ],
            [
                'name' => 'Dedi Kurniawan',
                'email' => 'dedi@gmail.com',
                'password_hash' => password_hash('password123', PASSWORD_DEFAULT),
                'role' => 'user',
                'created_at' => date('Y-m-d H:i:s', strtotime('-32 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-32 days'))
            ],
            [
                'name' => 'Maya Putri',
                'email' => 'maya@gmail.com',
                'password_hash' => password_hash('password123', PASSWORD_DEFAULT),
                'role' => 'user',
                'created_at' => date('Y-m-d H:i:s', strtotime('-28 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-28 days'))
            ],
            [
                'name' => 'Rizki Pratama',
                'email' => 'rizki@gmail.com',
                'password_hash' => password_hash('password123', PASSWORD_DEFAULT),
                'role' => 'user',
                'created_at' => date('Y-m-d H:i:s', strtotime('-25 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-25 days'))
            ],
            [
                'name' => 'Indah Sari',
                'email' => 'indah@gmail.com',
                'password_hash' => password_hash('password123', PASSWORD_DEFAULT),
                'role' => 'user',
                'created_at' => date('Y-m-d H:i:s', strtotime('-20 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-20 days'))
            ],
            [
                'name' => 'Ahmad Fauzi',
                'email' => 'ahmad@gmail.com',
                'password_hash' => password_hash('password123', PASSWORD_DEFAULT),
                'role' => 'user',
                'created_at' => date('Y-m-d H:i:s', strtotime('-15 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-15 days'))
            ],
            [
                'name' => 'Lestari Wulan',
                'email' => 'lestari@gmail.com',
                'password_hash' => password_hash('password123', PASSWORD_DEFAULT),
                'role' => 'user',
                'created_at' => date('Y-m-d H:i:s', strtotime('-12 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-12 days'))
            ],
            [
                'name' => 'Hendra Wijaya',
                'email' => 'hendra@gmail.com',
                'password_hash' => password_hash('password123', PASSWORD_DEFAULT),
                'role' => 'user',
                'created_at' => date('Y-m-d H:i:s', strtotime('-8 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-8 days'))
            ],
            [
                'name' => 'Eka Rahayu',
                'email' => 'eka@gmail.com',
                'password_hash' => password_hash('password123', PASSWORD_DEFAULT),
                'role' => 'user',
                'created_at' => date('Y-m-d H:i:s', strtotime('-5 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-5 days'))
            ],
            [
                'name' => 'Fajar Ramadhan',
                'email' => 'fajar@gmail.com',
                'password_hash' => password_hash('password123', PASSWORD_DEFAULT),
                'role' => 'user',
                'created_at' => date('Y-m-d H:i:s', strtotime('-3 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-3 days'))
            ],
            [
                'name' => 'Dewi Kartika',
                'email' => 'dewi@gmail.com',
                'password_hash' => password_hash('password123', PASSWORD_DEFAULT),
                'role' => 'user',
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-1 day'))
            ]
        ];

        // Check if users already exist to avoid duplicates
        foreach ($users as $user) {
            $existingUser = $this->db->table('users')->where('email', $user['email'])->get()->getRow();
            if (!$existingUser) {
                $this->db->table('users')->insert($user);
            }
        }
        
        echo "✅ Successfully seeded users with proper timestamps\n";
    }
}
