<?php

namespace App\Controllers;

use App\Models\CartModel;
use App\Models\MemberModel;
use App\Models\MemberTokenModel;
use CodeIgniter\API\ResponseTrait;
use Ramsey\Uuid\Uuid;

class LoginMember extends BaseController{
    use ResponseTrait;
    
    public function loginMember(){
        $data = $this->request->getPost();

        $email = $data['email'];
        $password = $data['password'];

        $MemberModel = new MemberModel();
        $memberTokenModel = new MemberTokenModel();
        $cartModel = new CartModel();
        $member = $MemberModel->where('member_email', $email)->first();
        
        if($member){
            if($member->member_password === $password){
                $member_id = $member->member_id;
                $uuid = Uuid::uuid4();
                $currDate = date('Y-m-d H:i:s');

                $tokenData = [
                    'member_id' => $member_id,
                    'member_token_uuid' => $uuid,
                    'created_at' => $currDate
                ];

                $cartData = [
                    'member_id' => $member_id,
                    'cart_uuid' => $uuid,
                    'cart_total_price' => 0,
                    'created_at' => $currDate
                ];

                $memberTokenModel->insert($tokenData);
                $cartModel->insert($cartData);

                return $this->respond(['member_token_uuid'=> $uuid ,'message'=> 'Token Success Generately']);
            }
            return $this->fail('Invalid Email or Password');
        }

    }
}