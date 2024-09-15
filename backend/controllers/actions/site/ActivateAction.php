<?php

declare(strict_types=1);

namespace backend\controllers\actions\site;

use common\services\TokenServiceInterface;
use Throwable;
use Yii;
use yii\base\Action;
use yii\web\Response;

final class ActivateAction extends Action
{
    public function run(string $hash, TokenServiceInterface $tokenService): Response
    {
        try {
            $tokenService->activateUser(hash: $hash);

            Yii::$app->session->setFlash(
                key: 'success',
                value: 'Your account has been activated. Now you can sign in',
            );

            return $this->controller->redirect(url: '/login');
        } catch (Throwable $exception) {
            Yii::$app->session->setFlash(
                key: 'error',
                value: sprintf(
                    'An error occurred while activating your account. %s',
                    $exception->getMessage(),
                ),
            );

            return $this->controller->goHome();
        }
    }
}
