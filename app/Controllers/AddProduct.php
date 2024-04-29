<?php

namespace App\Controllers;

use App\Models\AdminTokenModel;
use App\Models\ProductModel;
use CodeIgniter\API\ResponseTrait;
use Ramsey\Uuid\Uuid;

class AddProduct extends BaseController{
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

    public function Insert(){
        $data = $this->request->getPost();
        $token = $this->checkHeder();

        $title = $data['title'];
        $desc = $data['description'];
        $price = $data['price'];
        $show = $data['shape'];
        

        $tokenModel = new AdminTokenModel();
        $tokenData = $tokenModel->where('admin_token_uuid', $token)->first();
        $currDate = date('Y-m-d H:i:s');
        $uuid = Uuid::uuid4()->toString();
        echo($show);

        if($show === 'show'){
            $dataShow = true;
        }else{
            $dataShow = false;
        }

        $productModel = new ProductModel();
        if($tokenData){
        
            $data = [
                'product_uuid' => $uuid,
                'product_title' => $title,
                'product_description' => $desc,
                'product_price' => $price,
                'product_show' => $dataShow,
                'created_at' => $currDate
            ];
            $productModel->insert($data);

            return $this->respond(['product_title' => $title,
            'product_description' => $desc,
            'product_price' => $price,
            'product_show' => $show,
            'message' => 'Success Add Product'
            ]);
        }
        return $this->fail('Token is Not Found');
    }
}