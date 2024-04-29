<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InsertImage extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'product_image_id' => [
              'type' => 'BIGINT',
              'unsigned' => TRUE,
              'auto_increment' => TRUE,
            ],
            'product_id' => [
              'type' => 'BIGINT',
            ],
            'product_image_uuid' => [
              'type' => 'CHAR',
              'constraint' => 36,
              'unique' => TRUE,
            ],
            'product_image' => [
              'type' => 'VARCHAR',
              'constraint' => 255,
            ],
            'product_image_order' => [
              'type' => 'BIGINT',
            ],
            'product_image_show' => [
              'type' => 'BOOLEAN', 
              'default' => FALSE,
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

          $this->forge->addKey('product_image_id', TRUE);
          $this->forge->createTable('product_image_ms');
    
    }

    public function down()
    {
        $this->forge->dropTable('product_image_ms');
    }
}
