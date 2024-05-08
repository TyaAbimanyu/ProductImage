<?php

namespace App\Models;

use App\Entities\OrderItem;
use CodeIgniter\Model;

class OrderItemModel extends Model{
    protected $table = 'order_item_ms';
    protected $primaryKey = 'order_item_id';
    protected $returnType = OrderItem::class;
    protected $allowedFields = [
        'order_id',
        'product_id',
        'order_item_uuid',
        'order_item_quantity',
        'order_item_total_price',
        'created_at'
    ];

    protected $useTimeStamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
}