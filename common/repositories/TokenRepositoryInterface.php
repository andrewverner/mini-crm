<?php

declare(strict_types=1);

namespace common\repositories;

use common\models\Token;
use common\models\User;

interface TokenRepositoryInterface
{
    public function findValidToken(string $hash): ?Token;

    public function findUnusedTokenByType(User $user, int $type): ?Token;
}
