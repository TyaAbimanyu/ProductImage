<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InsertProduct extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'product_id'          => [
                'type' => 'BIGINT', 
                'constraint' => 20, 
                'unsigned' => TRUE, 
                'auto_increment' => TRUE
            ],
            'product_uuid'       => [
                'type' => 'CHAR', 
                'constraint' => 36, 
                'unique' => TRUE
            ],
            'product_title'      => [
                'type' => 'VARCHAR', 
                'constraint' => 255
            ],
            'product_description' => [
                'type' => 'TEXT', 
            ],
            'product_price'     => [
                'type' => 'DOUBLE', 
            ],
            'product_show'       => [
                'type' => 'BOOLEAN', 
                'default' => FALSE
            ],
            'created_at'         => [
                'type' => 'DATETIME', 
            ],
            'updated_at'         => [
                'type' => 'DATETIME', 
            ],
            'deleted_at'         => [
                'type' => 'DATETIME', 
                'null' => TRUE
            ],
        ]);

        $this->forge->addKey('product_id', TRUE);
        $this->forge->createTable('product_ms');
    }

    public function down()
    {
        $this->forge->dropTable('product_ms');
    }
}
