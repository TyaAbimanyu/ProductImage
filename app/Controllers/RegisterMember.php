<?php

namespace App\Controllers;
use App\Models\MemberModel;
use CodeIgniter\API\ResponseTrait;
use Ramsey\Uuid\Uuid;

class RegisterMember extends BaseController{
    use ResponseTrait;

    public function registerMember(){
        $data = $this->request->getPost();
        
        $email = $data['email'];
        $password = $data['password'];
        $name = $data['name'];
        $phone = $data['phone'];

        $memberModel = new MemberModel();
        $uuid = Uuid::uuid4();
        $currDate = date('Y-m-d H:i:s');

        $member = [
            'member_uuid' => $uuid,
            'member_email' => $email,
            'member_password' => $password,
            'member_name' => $name,
            'member_phone' => $phone,
            'created_at' => $currDate
        ];
        $memberModel->insert($member);
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'User Successfully Registered']);
    }
}