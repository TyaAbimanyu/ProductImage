<?php

namespace App\Models;

use App\Entities\Cart;
use CodeIgniter\Model;

class CartModel extends Model{
    protected $table = 'cart_ms';
    protected $primaryKey = 'cart_id';
    protected $returnType = Cart::class;
    protected $allowedFields = [
        'member_id',
        'cart_uuid',
        'cart_total_price',
        'created_at',
        'updated_at'
    ];
    protected $useTimeStamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    
}