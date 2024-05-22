<?php 
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\BankModel;
use App\Models\CartItemModel;
use App\Models\CartModel;
use App\Models\MemberModel;
use App\Models\MemberTokenModel;
use App\Models\OrderItemModel;
use App\Models\OrderModel;
use CodeIgniter\API\ResponseTrait;
use Ramsey\Uuid\Uuid;

class GetDataCheckOut extends BaseController{
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

    public function getDataOrder(){
        $checkToken = $this->checkHeder();
        $tokenModel = new MemberTokenModel();
        $cartModel = new CartModel();
        $memberModel = new MemberModel();
        $bankModel = new BankModel();
        
        $checker = $tokenModel->where('member_token_uuid', $checkToken)->first();
        $memberId = $checker->member_id;
        $memberData = $memberModel->where('member_id', $memberId)->first();
        $cartData = $cartModel->where('member_id', $memberId)->first();
        $bankData = $bankModel->findAll();

        $NewbankData = [];
        foreach($bankData as $bank){
            array_push($NewbankData, [
                'bankId' => $bank->bank_uuid,
                'bankName' => $bank->bank_name,
                'bankNumber' => $bank->bank_account_number
            ]);
        }

        $data = [
            'memberUuid' => $memberData->member_uuid,
            'memberEmail' => $memberData->member_email,
            'memberName' => $memberData->member_name,
            'cartTotalPrice' => $cartData ? $cartData->cart_total_price : 0,
            'bankList' => $NewbankData
        ];

        return $this->respond(['data' => $data, 'success' => 'Success Get Data']);
    }

    public function submitCart(){
        $checkToken = $this->checkHeder();
        $data = $this->request->getPost();
        $totalPrice = $data['allTotalPrice'];
        $address = $data['address'];

        $memberTokenModel = new MemberTokenModel();
        $orderModel = new OrderModel();
        $orderItemModel = new OrderItemModel();
        $cartModel = new CartModel();
        $cartItemModel = new CartItemModel();
        

        $tokenData = $memberTokenModel->where('member_token_uuid', $checkToken)->first();
        // print_r($tokenData);
        $memberId = $tokenData->member_id;

        $cartData = $cartModel->where('member_id', $memberId)->first();
        $cartId = $cartData->cart_id;
        // print_r($cartId);

        $today = date('Ymd');
        $lastOrder = $orderModel->like('order_number', $today)->first();
        // print_r($lastOrder);
        if($lastOrder === null || $lastOrder === ''){
            $orderNumber = $today . '001';
        }else{
            $lastNumber = intval(substr($lastOrder->order_number, -3));
            $lastNumber = $lastNumber + 1;
            $lastNumber = sprintf('%03d', $lastNumber);
            $orderNumber = $today . $lastNumber;
        }

        $uuid = Uuid::uuid4();
        $currDate = date('Y-m-d H:i:s');
        $orderData = [
            'member_id' => $memberId,
            'order_uuid'=> $uuid,
            'order_number' => $orderNumber,
            'order_total_price' => $totalPrice,
            'order_address' => $address,
            'order_status' => 0,
            'created_at' => $currDate
        ];
        if(!$orderModel->insert($orderData)){
            return $this->fail('Fail Insert Data');
        }

        $cartItemData = $cartItemModel->where('cart_id', $cartId)->findAll();
        $orderData = $orderModel->where('order_number', $orderNumber)->first();

        foreach($cartItemData as $item){
            $orderItemData = [
                'order_id' => $orderData->order_id,
                'product_id' => $item->product_id,
                'order_item_uuid' => $uuid,
                'order_item_quantity' => $item->cart_item_quantity,
                'order_item_total_price' => $item->cart_item_total_price,
                'created_at' => $currDate
            ];

            if(!$orderItemModel->insert($orderItemData)){
                return $this->fail('Fail Insert Order');
            }
        }
        return $this->respond($orderData->order_number);
    }
}