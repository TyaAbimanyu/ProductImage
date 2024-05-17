<?php

namespace App\Models;

use App\Entities\CartItem;
use CodeIgniter\Model;

class CartItemModel extends Model{
    protected $table = 'cart_item_id';
    protected $primaryKey = 'cart_item_id';

    protected $returnType = CartItem::class;
    protected $allowedFields = [
        'cart_id',
        'product_id',
        'cart_item_uuid',
        'cart_item_quantity',
        'cart_item_price',
        'cart_item_total_price',
        'created_at'
    ];
    protected $useTimeStamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
}