<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InsertBank extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'bank_id' => [
                'type' => 'BIGINT',
                'auto_increment' => TRUE,
            ],
            'bank_uuid' => [
                'type' => 'CHAR',
                'constraint' => 36,
                'unique' => TRUE,
            ],
            'bank_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'bank_account_number' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'bank_order' => [
                'type' => 'BIGINT',
            ],
            'bank_show' => [
                'type' => 'BOOLEAN',
                'default' => true,
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
        $this->forge->addKey('bank_id', true);
        $this->forge->createTable('bank_ms');
    }

    public function down()
    {
        $this->forge->dropTable('bank_ms');
    }
}
