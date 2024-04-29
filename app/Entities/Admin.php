<?php 

namespace App\Entities;
use CodeIgniter\Entity\Entity;

class Admin extends Entity{
    protected $attributes = [
        'admin_id' => null, 
        'admin_uuid' => '',
        'admin_email' => '',
        'admin_password' => '',
        'admin_name' => '',
        'admin_activate' => false,
        'created_at' => '',
        'updated_at' => '',
        'deleted_at' => ''
    ];
}
