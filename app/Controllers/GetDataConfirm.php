<?php

namespace App\Controllers;
use App\Models\BankModel;
use App\Models\CartModel;
use App\Models\MemberModel;
use App\Models\MemberTokenModel;
use App\Models\OrderModel;
use App\Models\PaymentConfirmationModel;
use CodeIgniter\API\ResponseTrait;
use Ramsey\Uuid\Uuid;

class GetDataConfirm extends BaseController{
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

    public function getDataCheck(){
        $token = $this->checkHeder();
        $memberTokenModel = new MemberTokenModel();
        $bankModel = new BankModel();
        $cartModel = new CartModel();
        $memberModel = new  MemberModel();
        $orderModel = new OrderModel();
        
        $tokenData = $memberTokenModel->where('member_token_uuid', $token)->first();
        $memberId = $tokenData->member_id;
        $memberData = $memberModel->where('member_id', $memberId)->first();
        
        $cartData = $cartModel->where('member_id', $memberId)->first();
        $cartTotalPrice = $cartData->cart_total_price;

        $orderData = $orderModel->where('member_id', $memberId)->first();
        $orderNumber = $orderData->order_number;

        $bankData  = $bankModel->findAll();
        $newBankData = [];

        foreach($bankData as $data){
            array_push($newBankData,[
                'bankId' => $data->bank_uuid,
                'bankName' => $data->bank_name,
                'bankNumber' => $data->bank_account_number
            ]);
        }

        $datas = [
            'email' => $memberData->member_email,
            'memberName' => $memberData->member_name,
            'allTotalPrice' => $cartTotalPrice,
            'orderNumber' => $orderNumber,
            'bankList' => $newBankData
        ];

        return $this->respond(['data'=>$datas, 'success' => 'success show data']);
    }

    public function paymentSubmit(){
        $data = $this->request->getPost();
        $token = $this->checkHeder();

        $imageData =  $this->request->getFile('files');
        $listData = json_decode($data['data'], true);

        // print_r([$imageData, $listData]);
        // die;

        $path = './receipts/';
        if(!is_dir($path)){
            mkdir($path, 0755, true);
        }

        $paymentModel = new PaymentConfirmationModel();
        $tokenModel = new MemberTokenModel();
        $memberModel = new MemberModel();
        $orderModel = new OrderModel();
        $bankModel = new BankModel();

        $tokenData = $tokenModel->where('member_token_uuid', $token)->first();
        $memberId = $tokenData->member_id;

        $memberData = $memberModel->where('member_id', $memberId)->first();
        $orderData = $orderModel->where('order_number', $listData['orderNumber'])->first();
        $bankData = $bankModel->where('bank_uuid', $listData['bankId'])->first();

        if($imageData === null || $imageData->hasMoved() || $imageData === ''){
            return $this->fail('Failed to Add Receipt Image');
        }

        $newName = $imageData->getRandomName();

        if(!$imageData->move($path, $newName)){
            return $this->fail('Failed to Add Receipt Image');
        }

        $data = [
            'order_id' => $orderData->order_id,
            'bank_id' => $bankData->bank_id,
            'member_id' => $memberId,
            'payment_confirmation_uuid' => Uuid::uuid4(),
            'payment_confirmation_transfer_date' => $listData['confirmDate'],
            'payment_confirmation_bank_name' => $listData['bankName'],
            'payment_confirmation_account_name' => $listData['bankAccountName'],
            'payment_confirmation_account_number' => $listData['bankAccountNumber'],
            'payment_confirmation_total_payment' => $orderData->order_total_price,
            'payment_confirmation_receipt' => $newName,
            'payment_confirmation_status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        if($paymentModel->insert($data)){
            return $this->respond(['data' => $data, 'success' => 'Success To Pay The Items']);
        }

        unlink($path.'/'.$newName);
        return $this->fail('Failed to Update Order Status');
    }
}