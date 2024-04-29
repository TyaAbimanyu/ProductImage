<?php 
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\ProductModel;
use CodeIgniter\API\ResponseTrait;

class ViewProduct extends BaseController{
    use ResponseTrait;

    function getProduct(){
        $productModel = new ProductModel();
        $product = $productModel->findAll();
        $data = [];

        foreach($product as $products){
            if(!empty($products->product_title)){
                $data[] = [
                    'title' => $products->product_title,
                    'price' => $products->product_price,
                    'shows' => $products->product_show === '1' ? 'Show':'Hide'
                ];
            }
        }
        return $this->respond($data);
    }
}