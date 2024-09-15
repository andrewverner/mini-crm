<?php

declare(strict_types=1);

namespace common\services;

use backend\models\LoginForm;
use backend\models\SignUpForm;
use common\exceptions\ConflictException;
use common\exceptions\NotFoundException;
use common\models\User;
use Throwable;
use Yii;
use yii\base\Exception;
use yii\db\Expression;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

final readonly class UserService implements UserServiceInterface
{
    /**
     * @throws Exception
     */
    public function createUser(SignUpForm $signUpForm): bool
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $user = new User();
            $user->email = $signUpForm->email;
            $user->password = Yii::$app->getSecurity()->generatePasswordHash(password: $signUpForm->password);

            if (!$user->save()) {
                throw new \yii\db\Exception(message: 'An error occurred while saving a user');
            }
        } catch (Throwable) {
            $transaction->rollBack();
        }

        $transaction->commit();

        return true;
    }

    public function authenticateUser(LoginForm $loginForm): bool
    {
        $user = $loginForm->getUser();

        if ($user === null) {
            Yii::$app->session->setFlash(key: 'error', value: 'An error occurred');

            return false;
        }

        $duration = $loginForm->rememberMe ? 3600 * 24 * 30 : 0;

        return Yii::$app->user->login(identity: $user, duration: $duration);
    }

    /**
     * @throws NotFoundException|\Exception
     */
    public function assignRole(string $userId, string $roleName): void
    {
        if (Yii::$app->user->id === $userId) {
            throw new ConflictException(message: 'You can not assign/revoke a role to/from yourself');
        }

        $user = User::findOne(condition: $userId);

        if ($user === null || !$user->isValid()) {
            throw new NotFoundException(message: 'User not found, inactive/blocked or deleted');
        }

        if ($roleName === '') {
            Yii::$app->authManager->revokeAll(userId: $userId);

            return;
        }

        if (!empty(Yii::$app->authManager->getRolesByUser(userId: $userId))) {
            throw new ConflictException(message: 'User already has a role');
        }

        $role = Yii::$app->authManager->getRole(name: $roleName);

        if ($role === null) {
            throw new NotFoundException(message: 'Role not found');
        }

        Yii::$app->authManager->assign(role: $role, userId: $userId);
    }

    /**
     * @throws NotFoundHttpException
     * @throws BadRequestHttpException
     * @throws ConflictException
     */
    public function delete(string $userId): void
    {
        if (Yii::$app->user->id === $userId) {
            throw new ConflictException(message: 'You can not delete yourself');
        }

        $model = User::findOne(condition: $userId);

        if ($model === null) {
            throw new NotFoundHttpException(message: 'User not found');
        }

        if ($model->deleted_at !== null) {
            throw new  BadRequestHttpException(message: 'User is already deleted');
        }

        $model->updateAttributes(['deleted_at' => new Expression(expression: 'NOW()')]);
        Yii::$app->authManager->revokeAll(userId: $userId);
    }

    /**
     * @throws NotFoundHttpException
     * @throws BadRequestHttpException
     * @throws ConflictException
     */
    public function block(string $userId): int
    {
        if (Yii::$app->user->id === $userId) {
            throw new ConflictException(message: 'You can not block/unblock yourself');
        }

        $model = User::findOne(condition: $userId);

        if ($model === null) {
            throw new NotFoundHttpException(message: 'User not found');
        }

        if ($model->deleted_at !== null) {
            throw new  BadRequestHttpException(message: 'User is deleted');
        }

        $model->updateAttributes(['blocked' => $model->blocked ? 0 : 1]);
        $model->refresh();

        return $model->blocked;
    }
}
