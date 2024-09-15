<?php

declare(strict_types=1);

namespace backend\controllers\actions\user;

use common\services\UserServiceInterface;
use Throwable;
use Yii;
use yii\base\Action;
use yii\web\Response;

class DeleteAction extends Action
{
    public function run(string $id, UserServiceInterface $userService): Response
    {
        try {
            $userService->delete(userId: $id);

            Yii::$app->session->setFlash(
                key: 'success',
                value: 'User has been soft-deleted',
            );
        } catch (Throwable $exception) {
            Yii::$app->session->setFlash(
                key: 'error',
                value: $exception->getMessage(),
            );
        }

        return $this->controller->redirect(url: '/user');
    }
}
