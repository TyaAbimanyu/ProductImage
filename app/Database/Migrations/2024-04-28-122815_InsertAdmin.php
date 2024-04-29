<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InsertAdmin extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'admin_id' => [
                'type'           => 'BIGINT',
                'unsigned'       => TRUE,
                'auto_increment' => TRUE,
            ],
            'admin_uuid' => [
                'type'       => 'CHAR',
                'constraint' => 36,
                'unique'     => TRUE,
            ],
            'admin_email' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'admin_password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'admin_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'admin_activate' => [
                'type' => 'BOOLEAN', 
                'default'     => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('admin_id', true);
        $this->forge->createTable('admin_ms');

    }

    public function down()
    {
        $this->forge->dropTable('admin_ms');
    }
}
