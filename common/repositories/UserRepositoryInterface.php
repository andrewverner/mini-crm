<?php

declare(strict_types=1);

namespace common\repositories;

use common\models\User;

interface UserRepositoryInterface
{
    public function findActiveUser(string $email): ?User;
}
