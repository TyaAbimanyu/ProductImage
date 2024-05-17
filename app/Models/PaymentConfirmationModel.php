<?php

namespace App\Models;

use App\Entities\PaymentConfirmation;
use CodeIgniter\Model;

class PaymentConfirmationModel extends Model{
    protected $table = 'payment_confirmation_ms';
    protected $primaryKey = 'payment_confirmation_id';
    protected $returnType = PaymentConfirmation::class;
    protected $allowedFields = [
        'order_id',
        'bank_id',
        'member_id',
        'payment_confirmation_uuid',
        'payment_confirmation_transfer_date',
        'payment_confirmation_bank_name',
        'payment_confirmation_account_name',
        'payment_confirmation_account_number',
        'payment_confirmation_total_payment',
        'payment_confirmation_receipt',
        'payment_confirmation_status',
        'created_at'
    ];
    protected $useTimeStamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
}