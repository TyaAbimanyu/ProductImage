<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InsertToken extends Migration
{
    public function up()
    {   $this->forge->addField([
            'admin_token_id' =>[
                'type'           => 'BIGINT',
                'auto_increment' => TRUE,
            ],
            'admin_id' =>[
                'type'           => 'BIGINT',
            ],
            'admin_token_uuid' => [
                'type'       => 'CHAR',
                'constraint' => 36,
                'unique'     => TRUE,
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
        $this->forge->addKey('admin_token_id', true);
        $this->forge->createTable('admin_token_ms');
    }

    public function down()
    {
        $this->forge->dropTable('admin_token_ms');
    }
}
