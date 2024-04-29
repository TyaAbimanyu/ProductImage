<?php

namespace App\Entities;
use CodeIgniter\Entity\Entity;

class Product extends Entity{
    protected $attributes = [
        'product_id' => null,
        'product_uuid' => '',
        'product_title' => '',
        'product_description' => '',
        'product_price' => 0.0,
        'product_show' => false,
        'created_at' => '',
        'updated_at' => '',
        'deleted_at' => ''
    ];
}