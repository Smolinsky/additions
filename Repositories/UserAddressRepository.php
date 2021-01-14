<?php

namespace App\Repositories;

use App\Models\Address;
use App\Repositories\Contracts\UserAddressInterface;

class UserAddressRepository implements UserAddressInterface
{
    public function get(int $userId): Address
    {
        return Address::where('user_id', $userId)->first();
    }

    public function update(Address $address, array $attributes): Address
    {
        $address->update($attributes);

        return $address;
    }
}
