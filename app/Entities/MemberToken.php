<?php

namespace App\Entities;
use CodeIgniter\Entity\Entity;

class MemberToken extends Entity{
    protected $attributes = [
        'member_token_id' => null,
        'member_id' => null,
        'member_token_uuid' => '',
        'created_at' => '',
        'updated_at' => '',
        'deleted_at' => ''

    ];
}