<?php 
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\AdminTokenModel;
use App\Models\ProductImageModel;
use App\Models\ProductModel;
use CodeIgniter\API\ResponseTrait;

class ViewProduct extends BaseController{
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
    function getProduct(){
        $token = $this->checkHeder();
        
        $tokenModel = new AdminTokenModel();
        $tokenData = $tokenModel->where('admin_token_uuid', $token)->first();
        
        $productModel = new ProductModel();
        $product = $productModel->findAll();
        $data = [];

        if($tokenData){
            foreach($product as $products){
                if(!empty($products->product_title)){
                    $data[] = [
                        'productId' => $products->product_uuid,
                        'title' => $products->product_title,
                        'price' => $products->product_price,
                        'shows' => $products->product_show === '1'? 'Show':'Hide',
                    ];
                }
            }
            return $this->respond($data);
        }
        return $this->fail('Token Not Found');
    }

    function updateStatus(){
        $data = $this->request->getRawInput();

        $productModel = new ProductModel();
        $produtData = $productModel->where('product_uuid', $data['productId'])->first();

        $dataShow  = [
            'product_show' =>  $produtData->product_show == "1" ? "0":"1"

        ];
        print_r($dataShow);

        if($productModel->where('product_uuid', $data['productId'])->update(null, $dataShow)){
            return $this->respond(['Successfully Change Show Status']);
        }
        return $this->fail(['Failed to Change Status']);
    }

    function getUpdateProduct($productId){
        $productModel = new ProductModel();
        $product = $productModel->select('product_title, product_description, product_price, product_show')->where('product_uuid', $productId)->first();

        $data = [
            'title' => $product->product_title,
            'description' => $product->product_description,
            'price' => $product->product_price,
            'shape' => $product->product_show === '1'? 'Show':'Hide',
        ];

        if(empty($data)){
            return $this->fail('Data Not Found');
        }
        return $this->respond($data);
    }

    function UpdateData(){
        $data = $this->request->getRawInput();
        $title = $data['title'];
        $desc = $data['description'];
        $price = $data['price'];
        $show = $data['shape'];
        $prodcutId = $data['productId'];

        $productModel = new ProductModel();
        $Newdata = [
            'product_title' => $title,
            'product_description' => $desc,
            'product_price' => $price,
            'product_show' => $show
        ];

        $productModel->where('product_uuid', $prodcutId)->update(null,$Newdata);
        if($productModel){
            return $this->respond('Success Updated Data');
        }
        return $this->fail('Faild To Update Data');
    }

    public function deletedData($productId){
        $db = db_connect();
        $db->transBegin();
        $path = './uploads/';

        $productModel = new ProductModel();
        $imageModel = new ProductImageModel();

        $productData = $productModel->where('product_uuid', $productId)->first();
        $imageData = $imageModel->where('product_id', $productData->product_id)->findAll();

        if($productModel->where('product_uuid', $productId)->delete() && $imageModel->where('product_id', $productData->product_id)->delete()){
            foreach($imageData as $data){
                unlink($path . $data->product_image);
            }
            $db->transCommit();
            return $this->respond('Data Successfully Deleted');
        }
        $db->transRollback();
        return $this->fail('Failed to Deleted Data or Image');
    }
}