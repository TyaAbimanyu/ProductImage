<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InsertMember extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'member_id' => [
                'type' => 'BIGINT',
                'auto_increment' => TRUE,
            ],
            'member_uuid' => [
                'type' => 'CHAR',
                'constraint' => 36,
                'unique' => TRUE,
            ],
            'member_email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'unique' => TRUE,
            ],
            'member_password' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'member_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'member_phone' => [
                'type' => 'VARCHAR',
                'constraint' => 15,
            ],
            'member_active' => [
                'type' => 'BOOLEAN',
                'default' => TRUE,
            ],
            'created_at' => [
                'type' => 'DATETIME',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => TRUE,
            ],
        ]);
        $this->forge->addKey('member_id', true);
        $this->forge->createTable('member_ms');
    }

    public function down()
    {
        $this->forge->dropTable('member_ms');
    }
}
