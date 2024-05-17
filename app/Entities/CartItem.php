<?php

namespace App\Entities;
use CodeIgniter\Entity\Entity;

class CartItem extends Entity{
    protected $attributes = [
        'cart_item_id' => null,
        'cart_id' => null,
        'product_id'=> null,
        'cart_item_uuid' => '',
        'cart_item_quantity' => '',
        'cart_item_price' => '',
        'cart_item_total_price' => '',
        'created_at' => '',
        'updated_at' => '',
        'deleted_at' => ''
    ];
}