<?php

namespace App\Entities;
use CodeIgniter\Entity\Entity;

class PaymentConfirmation extends Entity{
    protected $attributes = [
        'payment_confirmation_id' => null,
        'order_id' => null,
        'bank_id' => null,
        'member_id' => null,
        'payment_confirmation_uuid' => '',
        'payment_confirmation_transfer_date' => '',
        'payment_confirmation_bank_name' => '',
        'payment_confirmation_account_name' => '',
        'payment_confirmation_account_number' => '',
        'payment_confirmation_total_payment' => '',
        'payment_confirmation_receipt' => '',
        'payment_confirmation_status' => '',
        'created_at' => '',
        'updated_at' => '',
        'deleted_at' => ''
    ];
}