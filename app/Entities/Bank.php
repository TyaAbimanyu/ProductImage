<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Bank extends Entity{
    protected $attributes = [
        'bank_id' => null,
        'bank_uuid' => '',
        'bank_name' => '',
        'bank_account_number' => '',
        'bank_order' => '',
        'bank_show' => '',
        'created_at' => '',
        'updated_at' => '',
        'deleted_at' => ''
    ];
}