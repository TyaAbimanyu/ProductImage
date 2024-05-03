<?php

namespace App\Controllers;

use App\Models\AdminTokenModel;
use App\Models\ProductImageModel;
use App\Models\ProductModel;
use CodeIgniter\API\ResponseTrait;

class ViewImage extends BaseController{
    use ResponseTrait;

    function checkHeder(){
        $authorizationHeader = $this->request->getHeaderLine('Authorization');  

        if(empty($authorizationHeader)) {
            return 'Header is Empty';
        }

        $authorizationParts = explode(' ', $authorizationHeader);
        if(count($authorizationParts) !== 2 || strtolower($authorizationParts[0]) !== 'bearer') {            
            return 'Header not Valid';
        }

        $token = $authorizationParts[1];

        return $token;
    }

    public function getImage($productId){
        $productModel = new ProductModel();
        $imageModel = new ProductImageModel();

        $productData = $productModel->where('product_uuid', $productId)->first();
        $imageData = $imageModel->where('product_id', $productData->product_id)->findAll();

        if($productData === null && $imageData === null && $imageData === ''){
            return $this->fail('No Data Found');
        }

        $arr = [];

        foreach($imageData as $data){
            // array_push($arr, [
                
            // ]);
            $arr[] = [
                'productId' => $data->product_image_uuid,
                'image' => $data->product_image,
                'show' => $data->product_image_show ? "1" : "0"
            ];
        }
        return $this->respond(['title' => $productData->product_title, 'result' => $arr]);
    }

    public function statusUpdateImage(){
        $token = $this->checkHeder();
        
        $tokenModel = new AdminTokenModel();
        $tokenData = $tokenModel->where('admin_token_uuid', $token)->first();
        
        if($tokenData){
            $data = $this->request->getRawInput();
            $productModel = new ProductImageModel();
            $imageShow = $data['show'];
            $updateData = [
                'product_image_show' => $imageShow == "1" ? true : false
            ];
            
            if($productModel->where('product_image_uuid', $data['productId'])->update(null, $updateData)){
                return $this->respond(['Success Change Show Status']);
            }
            return $this->fail('Failed to Change Status Data');
        }
    }

    public function deleteImage($productId){
        $imageModel = new ProductImageModel();
        $path = './uploads/';

        $imageData = $imageModel->where('product_image_uuid', $productId)->first();

        if($imageModel->where('product_image_uuid', $productId)->delete()){
            unlink($path . $imageData->product_image);
            return $this->respond(["Success Deleted Data Image"]);
        }
        return $this->fail('Failed Deleted Image');
    }
}