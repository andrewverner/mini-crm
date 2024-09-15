<?php

declare(strict_types=1);

namespace common\repositories;

use common\models\User;

final class UserRepository implements UserRepositoryInterface
{
    public function findActiveUser(string $email): ?User
    {
        return User::findOne([
            'email' => $email,
            'active' => 1,
            'blocked' => 0,
            'deleted_at' => null,
        ]);
    }
}
