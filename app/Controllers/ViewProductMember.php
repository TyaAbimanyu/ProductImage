<?php

namespace App\Controllers;

use App\Models\ProductImageModel;
use App\Models\ProductModel;
use CodeIgniter\API\ResponseTrait;

class ViewProductMember extends BaseController{
    use ResponseTrait;

    public function getProductDataMember(){
        $productModel = new ProductModel();
        $imageModel = new ProductImageModel();

        $products = $productModel->findAll();
        $data = [];
        foreach($products as $product){
            $images = $imageModel->select('product_image')->where('product_id', $product->product_id)->find();
            $productData=[
                'productId' => $product->product_id,
                'title' => $product->product_title,
                'description' => $product->product_description,
                'price' => $product->product_price,
            ];

            $imageData = [];
            foreach($images as $image){
                array_push($imageData,[
                    'image' => $image->product_image
                ]);
            }
            array_push($data, [
                'product' => $productData,
                'image' => $imageData
            ]);
        }
        return $this->respond($data);
    }
}
