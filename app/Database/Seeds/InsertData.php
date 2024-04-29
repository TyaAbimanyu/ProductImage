<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Ramsey\Uuid\Uuid;

class InsertData extends Seeder
{
    public function run()
    {
        // $this->insertAdmin();
        $this->insertToken();
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
}
