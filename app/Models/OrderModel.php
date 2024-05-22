<?php

namespace App\Models;

use App\Entities\Order;
use CodeIgniter\Model;

class OrderModel extends Model{
    protected $table = 'order_ms';
    protected $primaryKey = 'order_id';
    protected $returnType = Order::class;
    protected $allowedFields = [
        'member_id',
        'order_uuid',
        'order_number',
        'order_total_price',
        'order_address',
        'order_status',
        'created_at'
    ];

    protected $useTimeStamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
}