<?php

namespace App\Controllers;
use App\Models\AdminTokenModel;
use App\Models\OrderModel;
use CodeIgniter\API\ResponseTrait;

class ViewOrder extends BaseController{
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

    function getOrder(){
        $token = $this->checkHeder();
        $tokenModel = new AdminTokenModel();
        $tokenData = $tokenModel->where('admin_token_uuid', $token)->first();

        $orderModel = new OrderModel();
        $order = $orderModel->findAll();

        foreach($order as $orders){
            if(!empty($orders->order_number)){
                $tanggal = explode(' ', $orders->created_at)[0];
                $data[] = [
                    'orderId' => $orders->order_uuid,
                    'orderNumber' => $orders->order_number,
                    'dateTime' => $tanggal,
                    'totalPrice' => $orders->order_total_price,
                    'status' => $orders->order_status === '1'? 'Paid':'Unpaid',
                ];
            }
        }
        return $this->respond($data);
    }

    public function deletedOrder($orderId){
    
        $orderModel = new OrderModel();

        $orderData = $orderModel->where('order_uuid', $orderId)->first();

        if($orderData){
            $deleteData = $orderModel->where('order_uuid', $orderId)->delete();
            if($deleteData){
                return $this->respond('Success Delete Data');
            }
            return $this->fail('Failed to Delete Data');
        }
        return $this->fail('Data Not Found');
    }
}