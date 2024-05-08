<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\ProductImageModel;
use App\Models\ProductModel;
use CodeIgniter\API\ResponseTrait;
use Ramsey\Uuid\Uuid;

class AddOrder extends BaseController{
    use ResponseTrait;

    public function getProductData(){
        $productModel = new ProductModel();
        $imageModel = new ProductImageModel();

        $products = $productModel->findAll();
        $data = [];
        foreach($products as $product){
            $images = $imageModel->select('product_image')->where('product_id', $product->product_id)->find();
            $productData=[
                'productId' => $product->product_id,
                'title' => $product->product_title,
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
        // return $this->respond(['title' => $product->product_title, 'price' => $product->product_price ,'result' => $data]);
        return $this->respond($data);
    }

    public function searchOrder($title) {
        $productModel = new ProductModel();
        $imageModel = new ProductImageModel();

        $products = $productModel->like('product_title', $title)->findAll();
        $data = [];
        foreach ($products as $product) {
            $images = $imageModel->select('product_image')->where('product_id', $product->product_id)->find();

            $productData = [
                'productId' => $product->product_id,
                'title' => $product->product_title,
                'price' => $product->product_price,
            ];

            $imageData = [];
            foreach ($images as $image) {
                array_push($imageData, ['image' => $image->product_image]);
            }

            array_push($data, [
                'product' => $productData,
                'image' => $imageData,
            ]);
        }

        return $this->respond($data);
    }

    private function countOrderData(){
        $orderModel = new OrderModel();
        $today = date('Y-m-d');
        return $orderModel->where('DATE(created_at)', $today)->countAllResults();
    }

    function insertOrder(){
        $data = $this->request->getPost();
        
        $order = new OrderModel();
        $totalPrice = $data['allTotalPrice'];

        if(!empty($totalPrice)){
            $uuid = Uuid::uuid4();
            $orderNumber = date('Ymd').sprintf('%03d',$this->countOrderData()+1);
            $currDate = date('Y-m-d H:i:s');
            $cart = [
                'order_uuid' => $uuid,
                'order_number' => $orderNumber,
                'order_total_price' => $totalPrice,
                'order_status' => 1,
                'created_at' => $currDate
            ];
            $order->insert($cart);
            return $this->respond(['message'=> 'Order Success Inserted']);
        }    
        return $this->fail(['message'=> 'Order Failed Inserted']);
    }

    // Function Buat Insert Peritem
    // function insertOrder(){
    //     $data = $this->request->getPost();
        
    //     $order = new OrderModel();

    //     $cartData = json_decode($data['cartItem'], true);
        
    //     foreach($cartData as $cartItem){
    //         $uuid = Uuid::uuid4();
    //         $orderNumber = date('Ymd').sprintf('%03d',$this->countOrderData()+1);
    //         $currDate = date('Y-m-d H:i:s');
    //         $cart = [
    //             'order_uuid' => $uuid,
    //             'order_number' => $orderNumber,
    //             'order_total_price' => $cartItem['totalPrice'],
    //             'order_status' => 1,
    //             'created_at' => $currDate

    //         ];
    //         $order->insert($cart);
    //     }
    //     return $this->respond(['message'=> 'Order Success Inserted']);
    // }
}