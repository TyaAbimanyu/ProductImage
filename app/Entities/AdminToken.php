<?php

namespace App\Entities;
use CodeIgniter\Entity\Entity;

class AdminToken extends Entity{
    protected $attributes = [
        'admin_token_id' => null,
        'admin_id' => null,
        'admin_token_uuid' => '',
        'created_at' => '',
        'updated_at' => '',
        'deleted_at' => ''
    ];
}