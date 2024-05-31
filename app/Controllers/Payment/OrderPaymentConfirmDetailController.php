<?php

namespace App\Controllers\Payment;

use App\Controllers\BaseController;
use App\Models\AdminTokenModel;
use App\Models\BankModel;
use App\Models\OrderModel;
use App\Models\PaymentConfirmationModel;
use CodeIgniter\API\ResponseTrait;

class OrderPaymentConfirmDetailController extends BaseController{
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

   function orderData($orderId){
    // var_dump($orderId);
        $token = $this->checkHeder();
        $tokenModel =  new AdminTokenModel();
        $tokenData = $tokenModel->where('admin_token_uuid', $token)->first();

        $orderModel = new OrderModel();
        //Buat Ambil Total Price ama date
        $orderData = $orderModel->select('order_total_price, created_at')->where('order_uuid', $orderId)->first();

        //Buat ambil Payment Status
        $orderIDobj = $orderModel->select('order_id')->where('order_uuid', $orderId)->first();
        $orderID = $orderIDobj->order_id;
        
        $paymentModel = new PaymentConfirmationModel();
        $paymentData = $paymentModel->select('payment_confirmation_total_payment,payment_confirmation_status')->where('order_id', $orderID)->first();

        // print_r($paymentData);
        if(!empty($tokenData)){
            $status = 'Not Found';
            switch ($paymentData->payment_confirmation_status) {
                case "0":
                    $status = "Pending";
                    break;
                case "1":
                    $status = "Approve";
                    break;
                case "2":
                    $status = "Reject";
                    break;
            }
            
            $data = [
                'dateTime' => $orderData->created_at,
                'totalPrice' => $paymentData->payment_confirmation_total_payment,
                'status' => $status
            ];

            return $this->respond(['OrderData'=> $data]);
        }
        return $this->fail('Your Not Admin, Cannot See');
   }

   function orderPaymentData($paymentId){
        $token = $this->checkHeder();
        $tokenModel =  new AdminTokenModel();
        $tokenData = $tokenModel->where('admin_token_uuid', $token)->first();

        $paymentModel = new PaymentConfirmationModel();
        $paymentData = $paymentModel->select('
            payment_confirmation_bank_name,
            payment_confirmation_account_name,
            payment_confirmation_account_number,
            payment_confirmation_total_payment,
            payment_confirmation_receipt
        ')->where('payment_confirmation_uuid', $paymentId)->first();
        // var_dump($paymentData);

        $bankIDobj = $paymentModel->select('bank_id')->where('payment_confirmation_uuid', $paymentId)->first();
        $bankID = $bankIDobj->bank_id;

        $bankModel = new BankModel();
        $bankData = $bankModel->select('bank_account_number')->where('bank_id', $bankID)->first();

        if(!empty($tokenData)){
            $data = [
                'bankNumber' => $bankData->bank_account_number,
                'bankName' => $paymentData->payment_confirmation_bank_name,
                'accountName' => $paymentData->payment_confirmation_account_name,
                'accountNumber' => $paymentData->payment_confirmation_account_number,
                'totalPayment' => $paymentData->payment_confirmation_total_payment,
                'image' => $paymentData->payment_confirmation_receipt
            ];
            return $this->respond(['PaymentData'=> $data]);
        }
        return $this->fail('Your Not Admin, Cannot See');
   }

   public function updateStatusPaymentApprove() {
    $token = $this->checkHeder();
    if (!$token) {
        return $this->failUnauthorized('Invalid token');
    }

    $tokenModel =  new AdminTokenModel();
    $tokenData = $tokenModel->where('admin_token_uuid', $token)->first();

    if (!$tokenData) {
        return $this->failUnauthorized('Unauthorized access');
    }

    $data = $this->request->getRawInput();
    if (!isset($data['paymentId'])) {
        return $this->fail('Missing paymentId');
    }

    $paymentModel = new PaymentConfirmationModel();
    $paymentData = $paymentModel->where('payment_confirmation_uuid', $data['paymentId'])->first();

    if (!$paymentData) {
        return $this->failNotFound('Payment data not found');
    }

    $updateStatus = $paymentModel->update($paymentData->payment_confirmation_id, ['payment_confirmation_status' => '1']);
    if ($updateStatus) {
        return $this->respond(['message' => 'Success Update Payment Status']);
    } else {
        return $this->fail('Failed To Update Status Payment');
    }
}

    public function updateStatusPaymentReject (){
        $token = $this->checkHeder();
    if (!$token) {
        return $this->failUnauthorized('Invalid token');
    }

    $tokenModel =  new AdminTokenModel();
    $tokenData = $tokenModel->where('admin_token_uuid', $token)->first();

    if (!$tokenData) {
        return $this->failUnauthorized('Unauthorized access');
    }

    $data = $this->request->getRawInput();
    if (!isset($data['paymentId'])) {
        return $this->fail('Missing paymentId');
    }

    $paymentModel = new PaymentConfirmationModel();
    $paymentData = $paymentModel->where('payment_confirmation_uuid', $data['paymentId'])->first();

    if (!$paymentData) {
        return $this->failNotFound('Payment data not found');
    }

    $updateStatus = $paymentModel->update($paymentData->payment_confirmation_id, ['payment_confirmation_status' => '2']);
    if ($updateStatus) {
        return $this->respond(['message' => 'Success Update Payment Status']);
    } else {
        return $this->fail('Failed To Update Status Payment');
    }
    }
}