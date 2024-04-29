<?php

namespace App\Models;

use App\Entities\Admin;
use CodeIgniter\Model;

class AdminModel extends Model{
    protected $table = 'admin_ms';
    protected $primaryKey = 'admin_id';
    protected $returnType = Admin::class;
    protected $allowedFields = ['admin_uuid', 'admin_email', 'admin_password', 'admin_name','created_at'];
    protected $useTimeStamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    
}