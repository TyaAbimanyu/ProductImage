<?php

namespace App\Controllers\Payment;

use App\Controllers\BaseController;
use App\Models\AdminTokenModel;
use App\Models\OrderModel;
use App\Models\PaymentConfirmationModel;
use CodeIgniter\API\ResponseTrait;

class OrderPaymentConfirmController extends BaseController{
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

    public function getOrderNumber($orderId){
        $token = $this->checkHeder();
        $tokenModel = new AdminTokenModel();
        $tokenData = $tokenModel->where('admin_token_uuid', $token)->first();

        $orderModel = new OrderModel();
        $orderData = $orderModel->select('order_number')->where('order_uuid', $orderId)->first();

        if(!empty($tokenData)){
            $data = [
                'orderNumber' => $orderData->order_number
            ];
            return $this->respond(['orderData' => $data]);
        }
        return $this->fail('Failed Show Data');
    }

    public function getPaymentData($orderId){
        $token = $this->checkHeder();
        $tokenModel = new AdminTokenModel();
        $tokenData = $tokenModel->where('admin_token_uuid', $token)->first();

        $orderModel = new OrderModel();
        $orderData = $orderModel->select('order_id')->where('order_uuid', $orderId)->first();

        $paymentModel = new PaymentConfirmationModel();
        $payments = $paymentModel->where('order_id', $orderData->order_id)->findAll();
        $stats = $paymentModel->where('order_id', $orderData->order_id)->findAll();
        

        $datas = [];
        if(!empty($tokenData)){
            foreach ($stats as $stat) {
                if ($stat->payment_confirmation_status == "1") {
                    $status = "Approve";
                    break;
                } elseif ($stat->payment_confirmation_status == "0") {
                    $status = "Pending";
                }elseif ($stat->payment_confirmation_status == "2") {
                    $status = "Reject";
                }
            }
            foreach ($payments as $payment) {
                // $status = "Not Found";
                $datas[] = [
                    'paymentId' => $payment->payment_confirmation_uuid,
                    'bankName' => $payment->payment_confirmation_bank_name,
                    'accountName' => $payment->payment_confirmation_account_name,
                    'accountNumber' => $payment->payment_confirmation_account_number,
                    'date' => $payment->payment_confirmation_transfer_date,
                    'status' => $status
                ];
            }
            return $this->respond($datas);
        }
        return $this->fail('Fail Show Data, User Not Found');
    }

    public function updateStatusPayment (){
        $token = $this->checkHeder();
        $tokenModel = new AdminTokenModel();
        $tokenData = $tokenModel->where('admin_token_uuid', $token)->first();

        $data = $this->request->getRawInput();

        $paymentModel = new PaymentConfirmationModel();
        if(!empty($tokenData)){
            $paymentData = $paymentModel->where('payment_confirmation_uuid', $data['paymentId'])->first();

            $dataShow = [
                'payment_confirmation_status' => $paymentData->payment_confirmation_status == "1" ? "2":"1"
            ];


            if($paymentModel->where('payment_confirmation_uuid', $data['paymentId'])->update(null,$dataShow)){
                return $this->respond('Success Update Payment Status');
            }
            return $this->fail('Failed To Update Status Payment');
        }
        return $this->fail('Your Not Admin, cannot Update');
    }
}