<?php

namespace App\Entities;
use CodeIgniter\Entity\Entity;

class ProductImage extends Entity{
    protected $attributes = [
        'product_image_id' => null,
        'product_id' => null,
        'product_image_uuid' => '',
        'product_image' => '',
        'product_image_order' => 0,
        'product_image_show' => false,
        'created_at' => '',
        'updated_at' => '',
        'deleted_at' => ''
    ];
}