<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InsertPaymentConfirmation extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'payment_confirmation_id' => [
                'type' => 'BIGINT',
                'auto_increment' => TRUE,
            ],
            'order_id' => [
                'type' => 'BIGINT',
            ],
            'bank_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => TRUE,
                'null' => TRUE,
            ],
            'member_id' => [
                'type' => 'BIGINT',
            ],
            'payment_confirmation_uuid' => [
                'type' => 'CHAR',
                'constraint' => 36,
                'unique' => TRUE,
            ],
            'payment_confirmation_transfer_date' => [
                'type' => 'DATE',
            ],
            'payment_confirmation_bank_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'payment_confirmation_account_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'payment_confirmation_account_number' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'payment_confirmation_total_payment' => [
                'type' => 'DOUBLE',
            ],
            'payment_confirmation_receipt' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'payment_confirmation_status' => [
                'type' => 'INT',
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
        
        $this->forge->addKey('payment_confirmation_id', true);
        $this->forge->createTable('payment_confirmation_ms');
    }

    public function down()
    {
        $this->forge->dropTable('payment_confirmation_ms');
    }
}
