<?php

namespace App\Models;

use App\Entities\Bank;
use CodeIgniter\Model;

class BankModel extends Model{
    protected $table = 'bank_ms';
    protected $primaryKey = 'bank_id';

    protected $returnType = Bank::class;
    protected $allowedFields = [
        'bank_uuid',
        'bank_name',
        'bank_account_name',
        'bank_account_number',
        'bank_order',
        'bank_show',
        'created_at',
        'updated_at'
    ];
    protected $useTimeStamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
}