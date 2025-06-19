<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSpeedHistoryTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'download_speed' => [
                'type' => 'DECIMAL',
                'constraint' => '6,2',
            ],
            'upload_speed' => [
                'type' => 'DECIMAL',
                'constraint' => '6,2',
            ],
            'ping' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'tested_at' => [
                'type' => 'DATETIME',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('speed_history');
    }

    public function down()
    {
        $this->forge->dropTable('speed_history');
    }
}
