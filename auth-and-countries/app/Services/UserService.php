<?php

namespace App\Services;

use App\Exceptions\UserNotFoundException;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserService
{
    public function find(int $id): UserResource
    {
        $user = User::find($id);

        if (empty($user)) {
            throw new UserNotFoundException();
        }

        if ($user->email_verified_at === null) {
            throw new UserNotFoundException();
        }

        return UserResource::make($user);
    }
}
