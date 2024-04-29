<?php

namespace App\Models;

use App\Entities\AdminToken;
use CodeIgniter\Model;

class AdminTokenModel extends Model{
    protected $table = 'admin_token_ms';
    protected $primaryKey = 'admin_token_id';
    protected $returnType = AdminToken::class;
    protected $allowedFields = ['admin_id', 'admin_token_uuid', 'created_at'];
    protected $useTimeStamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
}