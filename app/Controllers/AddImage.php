<?php
namespace App\Controllers;

use App\Models\AdminTokenModel;
use App\Models\ProductImageModel;
use App\Models\ProductModel;
use CodeIgniter\API\ResponseTrait;
use Ramsey\Uuid\Uuid;

class AddImage extends BaseController{
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

    public function InserImg(){
        $token = $this->checkHeder();
        
        $tokenModel = new AdminTokenModel();
        $tokenData = $tokenModel->where('admin_token_uuid', $token)->first();
        $errorData = [];

        if($tokenData){
            $db = db_connect();
            $db->transBegin();

            $data = $this->request->getPost();
            $dataFile = $this->request->getFileMultiple('file');
            $status = $data['shape'];

            $path = './uploads';

            $productModel = new ProductModel();
            $productData = $productModel->where('product_uuid', $data['productId'])->first();

            if(!is_dir($path)){
                mkdir($path, 0755, true);
            }

            foreach($dataFile as $datas){
                if($data === null || $datas->hasMoved() || $datas === ''){
                    return $this->fail('Failed to upload Image');
                }
                $newName = $datas->getRandomName();

                if(!$datas->move($path, $newName)){
                    continue;
                }

                $imageModel = new ProductImageModel();
                $imageData = $imageModel->selectMax('product_image_order')->where('product_id', $productData->product_id)->first();
                $imageOrder = $imageData->product_image_order + 1;
                $uuid = Uuid::uuid4();
                $currDate = date('Y-m-d H:i:s');

                $insertData = [
                    'product_id' => $productData->product_id,
                    'product_image_uuid' => $uuid,
                    'product_image' =>$newName,
                    'product_image_order' => $imageOrder,
                    'product_image_show' => $status == "show" ? "1":"0",
                    'created_at' => $currDate
                ];

                if(!$imageModel->insert( $insertData )) {
                    array_push($erroData, $insertData);
                    continue;
                }
            }
            if(count($errorData) > 0 ){
                $db->transRollback();
                return $this->fail('Failed to Upload Data images');
            }

            $db->transCommit();
            return $this->respond('Success Upload Images');
        }
        return $this->fail('Token is Not Found');
    }
}