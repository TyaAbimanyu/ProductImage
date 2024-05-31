<?php

namespace App\Controllers\Member;
use App\Controllers\BaseController;
use App\Models\AdminTokenModel;
use App\Models\MemberModel;
use App\Models\OrderModel;
use CodeIgniter\API\ResponseTrait;

class MemberDetailController extends BaseController{
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
    function getMemberDetailData($memberId){
        $token = $this->checkHeder();
        $tokenModel = new AdminTokenModel();
        $tokenData = $tokenModel->where('admin_token_uuid', $token)->first();

        $memberModel = new MemberModel();
        $memberData = $memberModel->select('member_id, member_email, member_name, member_phone')
        ->where('member_uuid', $memberId)
        ->first();

        $orderModel = new OrderModel();
        $orders =  $orderModel->where('member_id', $memberData->member_id)->findAll();
        // print_r($orders);
        // die;

        if(!empty($tokenData)){
            // $status = 'No Orders';
            foreach ($orders as $order) {
                if ($order->order_status == "1") {
                    $status = "Approve";
                    break;
                } elseif ($order->order_status == "0") {
                    $status = "Pending";
                }
            }
    
            $data = [
                'emailMember' => $memberData->member_email,
                'nameMember' => $memberData->member_name,
                'phoneMember' => $memberData->member_phone,
                'status' => $status
            ];
    
            return $this->respond(['memberData' => $data]);
        }
        return $this->fail('Fail Show Data, User Not Found');
    }

    public function getMemberOrderData($memberId){
        // print_r($memberId);
        $token = $this->checkHeder();
        $tokenModel = new AdminTokenModel();
        $tokenData = $tokenModel->where('admin_token_uuid', $token)->first();

        $memberModel = new MemberModel();
        $memberData = $memberModel->select('member_id')->where('member_uuid', $memberId)->first();
        // echo($memberData);

        $orderModel = new OrderModel();
        $orders = $orderModel->where('member_id', $memberData->member_id)->findAll();

        if(!empty($tokenData)){
            foreach($orders as $order){
                $data[] = [
                    'orderId' => $order->order_uuid,
                    'orderNumber' => $order->order_number,
                    'dateTime' => $order->created_at,
                    'totalPrice' => $order->order_total_price,
                    'status' => $order->order_status == "1" ? "Paid":"Unpaid"
                ];
            }
            return $this->respond($data);
        }
        return $this->fail('Fail Show Data, User Not Found');
    }

    public function deleteMemberData($orderId){
        $token = $this->checkHeder();

        $tokenModel = new AdminTokenModel();
        $tokenData = $tokenModel->where('admin_token_uuid', $token)->first();

        if(!empty($tokenData)){
            $orderModel =  new OrderModel();
            $orderData = $orderModel->where('order_uuid', $orderId)->first();

            if($orderData){

                $deletedData = $orderModel->where('order_uuid', $orderId)->delete();  
                if($deletedData){
                    return $this->respond('Succcess Deleted Data');
                }
                return $this->fail('Failed To Delete Data');
            }
            return $this->fail('Data Not Found');
        }
        return $this->fail('You Not Admin');
    }

    
    // public function deletedOrder($orderId){
    
    //     $orderModel = new OrderModel();

    //     $orderData = $orderModel->where('order_uuid', $orderId)->first();

    //     if($orderData){
    //         $deleteData = $orderModel->where('order_uuid', $orderId)->delete();
    //         if($deleteData){
    //             return $this->respond('Success Delete Data');
    //         }
    //         return $this->fail('Failed to Delete Data');
    //     }
    //     return $this->fail('Data Not Found');
    // }
}