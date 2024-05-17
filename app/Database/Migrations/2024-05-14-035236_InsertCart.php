<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InsertCart extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'cart_id' => [
                'type' => 'BIGINT',
                'auto_increment' => TRUE,
            ],
            'member_id' => [
                'type' => 'BIGINT',
            ],
            'cart_uuid' => [
                'type' => 'CHAR',
                'constraint' => 36,
                'unique' => TRUE,
            ],
            'cart_total_price' => [
                'type' => 'DOUBLE',
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
        $this->forge->addKey('cart_id', true);
        $this->forge->createTable('cart_ms');
    }

    public function down()
    {
        $this->forge->dropTable('cart_ms');
    }
}
