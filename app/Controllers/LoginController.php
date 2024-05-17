<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\AdminTokenModel;
use CodeIgniter\API\ResponseTrait;
use Ramsey\Uuid\Uuid;

class LoginController extends BaseController{
    use ResponseTrait;

    public function login(){
        $data = $this->request->getPost();

        $email = $data['email'];
        $password = $data['password'];
        $adminModel = new AdminModel();
        $admin = $adminModel->where('admin_email', $email)->first();

        if($admin){
            if($admin->admin_password === $password){
               
                $admin_id = $admin->admin_id;
                $uuid = Uuid::uuid4()->toString();
                $currDate = date('Y-m-d H:i:s');

                $adminTokenModel = new AdminTokenModel();
                $tokenData = [
                    'admin_id' => $admin_id,
                    'admin_token_uuid' => $uuid,
                    'created_at' => $currDate
                ];

                $adminTokenModel->insert($tokenData);
                $adminTokenId = $adminTokenModel->getInsertID();

                return $this->respond([
                    'admin_token_id'=> $adminTokenId, 
                    'admin_token_uuid' => $uuid, 
                    'created_at' => $currDate, 
                    'message' => 'Token Generately Successfully']);
            }else{
                return $this->fail('Invalid Email or Password');
            }
        }
    }
}