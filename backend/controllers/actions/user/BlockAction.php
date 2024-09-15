<?php

declare(strict_types=1);

namespace backend\controllers\actions\user;

use common\services\UserServiceInterface;
use Throwable;
use Yii;
use yii\base\Action;
use yii\web\Response;

class BlockAction extends Action
{
    public function run(string $id, UserServiceInterface $userService): Response
    {
        try {
             $result = $userService->block(userId: $id);

            Yii::$app->session->setFlash(
                key: 'success',
                value: sprintf(
                    'User has been %s',
                    $result === 1 ? 'blocked' : 'unblocked',
                ),
            );
        } catch (Throwable $exception) {
            Yii::$app->session->setFlash(
                key: 'error',
                value: $exception->getMessage(),
            );
        }

        return $this->controller->redirect(url: ['/user/view', 'id' => $id]);
    }
}
