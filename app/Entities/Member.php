<?php

namespace App\Entities;
use CodeIgniter\Entity\Entity;

class Member extends Entity{
    protected $attributes = [
        'member_id' => null,
        'member_uuid' => '',
        'member_email' => '',
        'member_password' => '',
        'member_name' => '',
        'member_phone' => '',
        'member_active' => '',
        'created_at' => '',
        'updated_at' => '',
        'deleted_at' => ''
    ];
}