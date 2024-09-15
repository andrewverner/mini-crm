<?php

declare(strict_types=1);

namespace common\services;

use backend\models\ResetPasswordForm;
use common\exceptions\NotFoundException;
use common\models\Token;
use common\models\User;
use common\enums\TokenTypeEnum;
use common\repositories\TokenRepositoryInterface;
use Faker\Provider\Uuid;
use Yii;
use yii\db\BaseActiveRecord;
use yii\db\Exception;
use yii\db\Expression;
use yii\web\BadRequestHttpException;

final readonly class TokenService implements TokenServiceInterface
{
    public function __construct(
        private TokenRepositoryInterface $tokenRepository,
    ) {
    }

    /**
     * @throws Exception
     */
    public function createActivationToken(User $user): bool
    {
        $token = $this->tokenRepository->findUnusedTokenByType(user: $user, type: TokenTypeEnum::ACTIVATION->value);

        if ($token === null) {
            $this->createToken(user: $user, type: TokenTypeEnum::ACTIVATION->value);
        } else {
            $token->updateAttributes(['expired_at' => new Expression(expression: 'NOW() + INTERVAL 3 DAY')]);
            $token->trigger(name: BaseActiveRecord::EVENT_AFTER_INSERT);
        }

        return true;
    }

    /**
     * @throws NotFoundException
     */
    public function activateUser(string $hash): void
    {
        $token = $this->tokenRepository->findValidToken(hash: $hash);

        if ($token === null) {
            throw new NotFoundException(
                message: 'Token not found, used or expired',
                code: 404,
            );
        }

        $token->user->updateAttributes(['active' => 1]);
        $token->updateAttributes(['used_at' => new Expression(expression: 'NOW()')]);
    }

    /**
     * @throws Exception
     */
    public function createResetPasswordToken(User $user): bool
    {
        $token = $this->tokenRepository->findUnusedTokenByType(
            user: $user,
            type: TokenTypeEnum::RESET_PASSWORD->value,
        );

        if ($token === null) {
            $this->createToken(user: $user, type: TokenTypeEnum::RESET_PASSWORD->value);
        } else {
            $token->updateAttributes(['expired_at' => new Expression(expression: 'NOW() + INTERVAL 3 DAY')]);
            $token->trigger(name: BaseActiveRecord::EVENT_AFTER_INSERT);
        }

        return true;
    }

    /**
     * @throws Exception
     */
    private function createToken(User $user, int $type): void
    {
        $model = new Token();
        $model->user_id = $user->getId();
        $model->value = strtoupper(string: md5(string: uniqid(prefix: Uuid::uuid(), more_entropy: true)));
        $model->type = $type;
        $model->created_at = new Expression(expression: 'NOW()');
        $model->expired_at = new Expression(expression: 'NOW() + INTERVAL 3 DAY');

        if (!$model->save()) {
            throw new Exception(message: 'An error occurred while saving a token');
        }
    }

    /**
     * @throws BadRequestHttpException
     * @throws \yii\base\Exception
     */
    public function resetPassword(ResetPasswordForm $resetPasswordForm): bool
    {
        $token = $this->tokenRepository->findValidToken(hash: $resetPasswordForm->hash);

        if ($token === null) {
            throw new BadRequestHttpException(message: 'Token is invalid', code: 500);
        }

        $token->user->updateAttributes([
            'password' => Yii::$app->security->generatePasswordHash($resetPasswordForm->password),
        ]);
        $token->used_at = new Expression(expression: 'NOW()');
        $token->save();

        return true;
    }
}
