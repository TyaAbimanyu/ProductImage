<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InsertTokenMember extends Migration
{
    public function up()
    {

        $this->forge->addField([
            'member_token_id' => [
                'type' => 'BIGINT',
                'auto_increment' => TRUE,
            ],
            'member_id' => [
                'type' => 'BIGINT',
            ],
            'member_token_uuid' => [
                'type' => 'CHAR',
                'constraint' => 36,
                'unique' => TRUE,
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
        $this->forge->addKey('member_token_id', true);
        $this->forge->createTable('member_token_trs');
    }

    public function down()
    {
        $this->forge->dropTable('member_token_trs');
    }
}
