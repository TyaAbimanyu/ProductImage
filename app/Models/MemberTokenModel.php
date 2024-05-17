<?php

namespace App\Models;

use App\Entities\MemberToken;
use CodeIgniter\Model;

class MemberTokenModel extends Model{
    protected $table = 'member_token_trs';
    protected $primaryKey = 'member_token_id';
    protected $returnType =  MemberToken::class;
    protected $allowedFields = [
        'member_id',
        'member_token_uuid',
        'created_at'
    ];
    protected $useTimeStamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

}