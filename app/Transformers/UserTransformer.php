<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param User $user
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'Name' => $user->name,
            'lastName' => $user->last_name,
            'idDocument' => $user->id_document,
            'email' => $user->email,
            'address' => $user->address,
            'phone' => $user->phone,
            'role' => $user->role,
        ];
    }
}
