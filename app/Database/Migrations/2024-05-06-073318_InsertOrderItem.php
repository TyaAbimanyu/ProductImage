<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InsertOrderItem extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'order_item_id' => [
                'type'           => 'BIGINT',
                'auto_increment' => true
            ],
            'order_id' => [
                'type'       => 'BIGINT',
            ],
            'product_id' => [
                'type'       => 'BIGINT',
            ],
            'order_item_uuid' => [
                'type' => 'CHAR',
                'constraint' => 36
            ],
            'order_item_quantity' => [
                'type'       => 'BIGINT',
            ],
            'order_item_total_price' => [
                'type' => 'DOUBLE'
            ],
            'created_at' => [
                'type' => 'DATETIME'
            ],
            'updated_at' => [
                'type' => 'DATETIME'
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true
            ]
        ]);
        $this->forge->addKey('order_item_id', true);
        $this->forge->createTable('order_item_ms');

    }

    public function down()
    {
        $this->forge->dropTable('order_item_ms');
    }
}
