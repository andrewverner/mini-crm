<?php

declare(strict_types=1);

namespace common\repositories;

use common\models\Token;
use common\models\User;
use yii\db\Expression;

final class TokenRepository implements TokenRepositoryInterface
{
    public function findValidToken(string $hash): ?Token
    {
        return Token::find()
            ->where(condition: ['value' => $hash, 'used_at' => null])
            ->andWhere(condition: ['>', 'expired_at', new Expression(expression: 'NOW()')])
            ->one();
    }

    public function findUnusedTokenByType(User $user, int $type): ?Token
    {
        return Token::findOne([
            'used_at' => null,
            'user_id' => $user->id,
            'type' => $type,
        ]);
    }
}
