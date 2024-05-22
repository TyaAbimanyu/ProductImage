<?php

namespace App\Controllers;

use App\Models\BankModel;
use App\Models\CartItemModel;
use App\Models\CartModel;
use App\Models\MemberTokenModel;
use App\Models\OrderModel;
use CodeIgniter\API\ResponseTrait;

class GetCheckOutSubmit extends BaseController{
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

    public function getDataSubmit(){
        $token = $this->checkHeder();
        $tokenModel = new MemberTokenModel();
        $orderModel =  new OrderModel();
        $bankModel = new BankModel();

        $tokenData = $tokenModel->where('member_token_uuid', $token)->first();
        $memberId = $tokenData->member_id;
        
        $orderData = $orderModel->where('member_id', $memberId)->first();
        $orderNumber = $orderData->order_number;

        $bankData = $bankModel->findAll();
        $newBankData = [];
        
        foreach($bankData as $data){
            array_push($newBankData,[
                'bankId' => $data->bank_uuid,
                'bankName' => $data->bank_name,
                'bankNumber' => $data->bank_account_number
            ]);
        }
        $datas = [
            'orderNumber' => $orderNumber,
            'bankList' => $newBankData
        ];

        return $this->respond(['data'=>$datas, 'success' => 'success show data']);
    
    }

    public function setConfirmOrder(){
        $token = $this->checkHeder();
        $data = $this->request->getRawInput();

        $tokenModel = new MemberTokenModel();
        $cartModel = new CartModel();
        $cartItemModel = new CartItemModel();
        $orderModel =  new OrderModel();

        $tokenData = $tokenModel->where('member_token_uuid', $token)->first();
        $memberId = $tokenData->member_id;

        $cartData = $cartModel->where('member_id', $memberId)->first();

        if($orderModel->where('order_number', $data['orderNumber'])->update(null,['order_status' => 1])){
            if($cartItemModel->where('cart_id', $cartData->cart_id)->delete()){
                $updateCartItemData = $cartItemModel->where('cart_id', $cartData->cart_id)
                ->findAll();

                $updateCartTotalPrice = 0;
                foreach($updateCartItemData as $data){
                    $updateCartTotalPrice += $data->cart_item_total_price;
                }

                if($cartModel->where('cart_id', $cartData->cart_id)->update(null, ['cart_total_price'=>$updateCartTotalPrice])){
                    return $this->respond(['success' => 'success update order status']);
                }
            }
        }
        return $this->fail('Failed to Update Order Status');
    }
}