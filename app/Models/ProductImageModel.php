<?php

namespace App\Models;

use App\Entities\ProductImage;
use CodeIgniter\Model;

class ProductImageModel extends Model{
    protected $table = 'product_image_ms';
    protected $primaryKey = 'product_image_id';
    protected $returnType = ProductImage::class;
    protected $allowedFields = ['product_id', 'product_image_uuid', 'product_image', 'product_image_order','product_image_show','created_at','updated_at'];
    protected $useTimeStamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
}