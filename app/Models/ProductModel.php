<?php

namespace App\Models;

use App\Entities\Product;
use CodeIgniter\Model;

class ProductModel extends Model{
    protected $table = 'product_ms';
    protected $primaryKey = 'product_id';
    protected $returnType = Product::class;
    protected $allowedFields = ['product_uuid', 
    'product_title', 
    'product_description', 
    'product_price',
    'product_show',
    'created_at'];
    protected $useSoftDeletes = false;
    protected $useTimeStamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
}