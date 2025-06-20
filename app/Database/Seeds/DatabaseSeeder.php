<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        echo "🌱 Starting database seeding...\n\n";
        
        // Run User Seeder
        $this->call('UserSeeder');
        
        // Run Package Seeder
        $this->call('PackageSeeder');
        
        // Run Admin Activities Seeder
        $this->call('AdminActivitiesSeeder');
        
        echo "\n🎉 Database seeding completed successfully!\n";
    }
}
