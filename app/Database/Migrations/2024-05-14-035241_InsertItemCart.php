<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InsertItemCart extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'cart_item_id' => [
                'type' => 'BIGINT',
                'auto_increment' => TRUE,
            ],
            'cart_id' => [
                'type' => 'BIGINT',
            ],
            'product_id' => [
                'type' => 'BIGINT',
            ],
            'cart_item_uuid' => [
                'type' => 'CHAR',
                'constraint' => 36,
                'unique' => TRUE,
            ],
            'cart_item_quantity' => [
                'type' => 'BIGINT',
            ],
            'cart_item_price' => [
                'type' => 'DOUBLE',
            ],
            'cart_item_total_price' => [
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
        
        $this->forge->addKey('cart_item_id', true);
        $this->forge->createTable('cart_item_id');
    }

    public function down()
    {
        $this->forge->dropTable('cart_item_id');
    }
}
