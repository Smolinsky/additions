<?php

namespace App\Repositories\Contracts;

use App\Models\Address;

interface UserAddressInterface
{
    public function get(int $userId): Address;

    public function update(Address $address, array $attributes): Address;
}
