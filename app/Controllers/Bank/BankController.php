<?php

namespace App\Controllers\Bank;
use App\Controllers\BaseController;

use App\Models\AdminTokenModel;
use App\Models\BankModel;
use App\Models\PaymentConfirmationModel;
use CodeIgniter\API\ResponseTrait;
use Ramsey\Uuid\Uuid;

class BankController extends BaseController{
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

    public function getBankData(){
        $token = $this->checkHeder();

        $paymentModel = new PaymentConfirmationModel();
        $bankModel = new BankModel(); 
        $banks = $bankModel->findAll();
        // $payments = $paymentModel->findAll();

        foreach($banks as $bank){
            // $payment = $paymentModel->where('payment_confirmation_account_number', $bank->bank_account_number)->first();
            // $accountName = $payment ? $payment->payment_confirmation_account_name : null;

            $data[] = [
                'bankId' => $bank->bank_uuid,
                'bankName' => $bank->bank_name,
                'accountName' => $bank->bank_account_name,
                'accountNumber' => $bank->bank_account_number,
                'status' => $bank->bank_show == "1" ? "Show":"Hide"
            ];
        }
        return $this->respond($data);
    }

    public function insertBankData(){
        $token = $this->checkHeder();
        $tokenModel = new AdminTokenModel();
        $bankModel = new BankModel();
        $tokenData = $tokenModel->where('admin_token_uuid', $token)->first();

        $data = $this->request->getPost();
        $bankName = $data['bankName'];
        $accountName = $data['accountName'];
        $accountNumber = $data['accountNumber'];
        $status = $data['shape'];

        $currDate = date('Y-m-d H:i:s');
        $uuid = Uuid::uuid4()->toString();
        if($status === 'show'){
            $dataShow = true;
        }else{
            $dataShow = false;
        }
        
        if(!empty($tokenData)){
            $bankData =[
                'bank_name' => $bankName,
                'bank_account_name' => $accountName,
                'bank_account_number' => $accountNumber,
                'bank_show' => $dataShow,
                'bank_order' => 1,
                'bank_uuid' => $uuid,
                'created_at' => $currDate
            ];
            $bankModel->insert($bankData);
        }
        return $this->respond('Success Insert Bank Data');
    }

    function updateStatus(){
        $data = $this->request->getRawInput();

        $bankModel = new BankModel();
        $bankData = $bankModel->where('bank_uuid', $data['bankId'])->first();

        $dataShow  = [
            'bank_show' =>  $bankData->bank_show == "1" ? "0":"1"

        ];

        if($bankModel->where('bank_uuid', $data['bankId'])->update(null, $dataShow)){
            return $this->respond(['Successfully Change Show Status']);
        }
        return $this->fail(['Failed to Change Status']);
    }

    function getUpdateBank($bankId){
        $bankModel = new BankModel();
        $token = $this->checkHeder();
        $tokenModel = new AdminTokenModel();
        $tokenData = $tokenModel->where('admin_token_uuid', $token)->first();
        $bank = $bankModel->select('bank_name, bank_account_name, bank_account_number, bank_show')->where('bank_uuid', $bankId)->first();

        if(!empty($tokenData)){
            $bankData = [
                'bankName' => $bank->bank_name,
                'accountName' => $bank->bank_account_name,
                'accountNumber' => $bank->bank_account_number,
                'shape' => $bank->bank_show === '1'? 'Show':'Hide',
            ];
    
            if(empty($bankData)){
                return $this->fail('Data Not Found');
            }
            return $this->respond($bankData);
        }
        return $this->respond('Success Insert Data');
    }

    function UpdateBankData(){
        $data = $this->request->getRawInput();
        $bankName = $data['bankName'];
        $accountName = $data['accountName'];
        $accountNumber = $data['accountNumber'];
        $shape = $data['shape'];
        $bankId = $data['bankId'];

        $bankModel = new BankModel();
        $currDate = date('Y-m-d H:i:s');
        $Newdata = [
            'bank_name' => $bankName,
            'bank_account_name' => $accountName,
            'bank_account_number' => $accountNumber,
            'bank_show' => $shape,
            'updated_at' => $currDate
        ];

        $bankModel->where('bank_uuid', $bankId)->update(null,$Newdata);
        if($bankModel){
            return $this->respond('Success Updated Data');
        }
        return $this->fail('Faild To Update Data');
    }

    public function deletedBank($bankId){
    
        $bankModel = new BankModel();

        $bankData = $bankModel->where('bank_uuid', $bankId)->first();

        if($bankData){
            $deleteData = $bankModel->where('bank_uuid', $bankId)->delete();
            if($deleteData){
                return $this->respond('Success Delete Data');
            }
            return $this->fail('Failed to Delete Data');
        }
        return $this->fail('Data Not Found');
    }
}