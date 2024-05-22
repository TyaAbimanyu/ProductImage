<?php

namespace App\Entities;
use CodeIgniter\Entity\Entity;

class Order extends Entity{
    protected $attributes = [
        'order_id' => null,
        'member_id' => null,
        'order_uuid' => '',
        'order_number' => '',
        'order_total_price' => '',
        'order_address' => '',
        'order_status' => '',
        'created_at' => '',
        'updated_at' => '',
        'deleted_at' => ''
    ];
}