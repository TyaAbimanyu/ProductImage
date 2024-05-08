<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class OrderItem extends Entity{
    protected $attributes = [
        'order_item_id' => null,
        'order_id' => null,
        'product_id' => null,
        'order_item_uuid' => '',
        'order_item_quantity' => '',
        'order_item_total_price' => '',
        'created_at' => '',
        'updated_at' => '',
        'deleted_at' => ''
    ];
}