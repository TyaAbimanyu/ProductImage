<?php

namespace App\Controllers\Member;
use App\Controllers\BaseController;
use App\Models\AdminTokenModel;
use App\Models\MemberModel;
use CodeIgniter\API\ResponseTrait;

class MemberController extends BaseController{
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

    public function getMemberData(){
        $token = $this->checkHeder();
        $memberModel = new MemberModel();
        $tokenModel = new AdminTokenModel();
        $tokenData = $tokenModel->where('admin_token_uuid', $token)->first();

        $members = $memberModel->findAll();

        if(!empty($tokenData)){
            foreach($members as $member){
                $data[] = [
                    'memberId' => $member->member_uuid,
                    'email' => $member->member_email,
                    'name' => $member->member_name,
                    'numberPhone' => $member->member_phone,
                    'status' => $member->member_active == "1" ? "Active":"Non Active"
                ];
            }
            return $this->respond($data);
        }
        return $this->fail('Failed Show Data, User Not Found');
    }

    function updateStatus(){
        $data = $this->request->getRawInput();

        $memberModel = new MemberModel();
        $memberData = $memberModel->where('member_uuid', $data['memberId'])->first();

        $dataShow  = [
            'member_active' =>  $memberData->member_active == "1" ? "0":"1"

        ];

        if($memberModel->where('member_uuid', $data['memberId'])->update(null, $dataShow)){
            return $this->respond(['Successfully Change Member Status']);
        }
        return $this->fail(['Failed to Change Status']);
    }
}