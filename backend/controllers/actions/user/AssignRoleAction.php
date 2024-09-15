<?php

declare(strict_types=1);

namespace backend\controllers\actions\user;

use common\services\UserServiceInterface;
use Throwable;
use yii\base\Action;
use yii\web\HttpException;

class AssignRoleAction extends Action
{
    public function run(UserServiceInterface $userService): void
    {
        $userId = $this->controller->request->post(name: 'id');
        $roleName = $this->controller->request->post(name: 'role');

        try {
            $userService->assignRole(userId: $userId, roleName: $roleName);
        } catch (Throwable $exception) {
            throw new HttpException(status: $exception->getCode(), message: $exception->getMessage());
        }
    }
}
