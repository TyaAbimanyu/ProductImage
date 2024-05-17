<?php 

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\AdminTokenModel;
use App\Models\MemberTokenModel;
use CodeIgniter\API\ResponseTrait;

class ValidateToken extends BaseController{
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
    function validateToken(){
        $checkToken = $this->checkHeder();
        $tokenModel = new AdminTokenModel();
        $checker = $tokenModel->where('admin_token_uuid', $checkToken)->first();

        if($checker){
            return $this->respond(['message' => 'Success', 'success'=>true]);
        }else{
            return $this->respond(['message' => 'Failed', 'success'=>false]);
        }
    }

    function validateTokenMember(){
        $checkToken = $this->checkHeder();
        $tokenModel = new MemberTokenModel();
        $checker = $tokenModel->where('member_token_uuid', $checkToken)->first();

        if($checker){
            return $this->respond(['message' => 'Success', 'success'=>true]);
        }else{
            return $this->respond(['message' => 'Failed', 'success'=>false]);
        }
    }
}