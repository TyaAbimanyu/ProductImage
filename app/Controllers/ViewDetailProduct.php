<?php

namespace App\Controllers;

use App\Models\ProductImageModel;
use App\Models\ProductModel;
use CodeIgniter\API\ResponseTrait;

class ViewDetailProduct extends BaseController {
    use ResponseTrait;

    public function getImageDetail($productId) {
        $productModel = new ProductModel();
        $imageModel = new ProductImageModel();

        $product = $productModel->find($productId);

        if (!$product) {
            return $this->failNotFound('Product not found');
        }

        $images = $imageModel->where('product_id', $productId)->findAll();

        $data = [
            'product' => [
                'product_id' => $product->product_id,
                'product_uuid' => $product->product_uuid,
                'product_title' => $product->product_title,
                'product_description' => $product->product_description,
                'product_price' => $product->product_price
            ],
            'images' => array_map(function ($image) {
                return [
                    'product_image' => $image->product_image,
                    'product_image_uuid' => $image->product_image_uuid
            ];
            }, $images)
        ];
        
        return $this->respond($data);
    }
}
