<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Ramsey\Uuid\Uuid;

class InsertData extends Seeder
{
    public function run()
    {
        $this->insertAdmin();
        // $this->insertToken();
        $this->insertCart();
        // $this->insertItemCart();
        $this->insertMember();
        // $this->inserTokenMember();
        $this->insertBank();
    }

    public function insertAdmin(){
        $uuid = Uuid::uuid4()->toString();
        $date = date('Y-m-d H:i:s');

        $adminData = [
            'admin_uuid' => $uuid,
            'admin_email' => 'admin@mail.com',
            'admin_password' => '12345',
            'admin_name' =>'aditya',
            'admin_activate' => true,
            'created_at' => $date
        ];

        $this->db->table('admin_ms')->insert($adminData);
    }

    public function insertToken(){
        $uuid = Uuid::uuid4()->toString();
        $date = date('Y-m-d H:i:s');

        $tokenData = [
            'admin_id' => 1,
            'admin_token_uuid' => $uuid,
            'created_at' => $date
        ];

        $this->db->table('admin_token_ms')->insert($tokenData);
    }

    public function insertMember(){
        $uuid = Uuid::uuid4()->toString();
        $date = date('Y-m-d H:i:s');

        $memberData = [
            'member_uuid' => $uuid,
            'member_email' => 'user11@mail.com',
            'member_password' => '12345',
            'member_name' => 'John Doe',
            'member_phone' => '081234567890',
            'member_active' => true,
            'created_at' => $date
        ];

        $this->db->table('member_ms')->insert($memberData);
    }

    public function inserTokenMember(){
        $uuid = Uuid::uuid4()->toString();
        $date = date('Y-m-d H:i:s');

        $tokenData = [
            'member_id' => 1,
            'member_token_uuid' => $uuid,
            'created_at' => $date
        ];

        $this->db->table('member_token_trs')->insert($tokenData);
    }

    public function insertBank(){
        $uuid = Uuid::uuid4()->toString();
        $date = date('Y-m-d H:i:s');

        $bankData = [
            'bank_uuid' => $uuid,
            'bank_name' => 'Bank BCA',
            'bank_account_number' => '1234567890',
            'bank_order' => 1,
            'bank_show' => true,
            'created_at' => $date
        ];

        $this->db->table('bank_ms')->insert($bankData);
    }

    public function insertCart(){
        $uuid = Uuid::uuid4()->toString();
        $date = date('Y-m-d H:i:s');

        $cartData = [
            'member_id' => 1,
            'cart_uuid' => $uuid,
            'cart_total_price' => 0.00,
            'created_at' => $date
        ];

        $this->db->table('cart_ms')->insert($cartData);
    }

    public function insertItemCart(){
        $uuid = Uuid::uuid4()->toString();
        $date = date('Y-m-d H:i:s');

        $cartItemData = [
            'cart_id' => 1,
            'product_id' => 27,
            'cart_item_uuid' => $uuid,
            'cart_item_quantity' => 2,
            'cart_item_price' => 100000.00,
            'cart_item_total_price' => 200000.00,
            'created_at' => $date
        ];
        $this->db->table('cart_item_ms')->insert($cartItemData);
    }
}
