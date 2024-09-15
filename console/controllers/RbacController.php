<?php

declare(strict_types=1);

namespace console\controllers;

use common\exceptions\ConflictException;
use common\models\User;
use common\services\UserServiceInterface;
use Exception;
use Throwable;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

final class RbacController extends Controller
{
    public ?string $email = null;

    public function options($actionID): array
    {
        return match ($actionID) {
            'set-admin' => ['email'],
            default => [],
        };
    }

    /**
     * @throws Exception
     */
    public function actionInit(): int
    {
        if (Yii::$app->authManager->getRole(name: 'admin') === null) {
            Yii::$app->authManager->add(object: Yii::$app->authManager->createRole(name: 'admin'));
            $this->stdout(string: 'Admin role has been created' . PHP_EOL);
        }

        if (Yii::$app->authManager->getRole(name: 'manager') === null) {
            Yii::$app->authManager->add(object: Yii::$app->authManager->createRole(name: 'manager'));
            $this->stdout(string: 'Manager role has been created' . PHP_EOL);
        }

        $this->stdout(string: 'Done' . PHP_EOL);

        return ExitCode::OK;
    }

    public function actionSetAdmin(): int
    {
        $role = Yii::$app->authManager->getRole(name: 'admin');

        if ($role === null) {
            $this->stdout(
                string: 'Admin role not found. Have you run RBAC init command "php yii rbac/init"?' . PHP_EOL
            );

            return ExitCode::UNSPECIFIED_ERROR;
        }

        $user = User::findOne(condition: [
            'email' => $this->email,
            'active' => 1,
            'blocked' => 0,
            'deleted_at' => null,
        ]);

        if ($user === null) {
            $this->stdout(string: 'User not found inactive/blocked or deleted' . PHP_EOL);

            return ExitCode::UNSPECIFIED_ERROR;
        }

        try {
            if (!empty(Yii::$app->authManager->getRolesByUser(userId: $user->id))) {
                throw new ConflictException(message: 'User is already an admin or a manager');
            }

            Yii::$app->authManager->assign(role: $role, userId: $user->id);
        } catch (Throwable $exception) {
            $this->stdout(string: 'An error occurred: ' . $exception->getMessage() . PHP_EOL);
        }

        $this->stdout(string: 'Done' . PHP_EOL);

        return ExitCode::OK;
    }
}
