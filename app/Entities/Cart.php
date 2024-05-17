<?php

namespace App\Entities;
use CodeIgniter\Entity\Entity;

class Cart extends Entity{

    protected $attributes = [
        'cart_id' => null,
        'member_id' => null,
        'cart_uuid' => '',
        'cart_total_price' => '',
        'created_at' => '',
        'updated_at' => '',
        'deleted_at' => ''
    ];
}