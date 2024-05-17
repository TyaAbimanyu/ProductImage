<?php

namespace App\Models;

use App\Entities\Member;
use CodeIgniter\Model;

class MemberModel extends Model{
    protected $table = 'member_ms';
    protected $primaryKey = 'member_id';
    protected $returnType = Member::class;
    protected $allowedFields = [
        'member_uuid',
        'member_email',
        'member_password',
        'member_name',
        'member_phone',
        'member_active',
        'created_at'
    ];
    protected $useTimeStamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
}