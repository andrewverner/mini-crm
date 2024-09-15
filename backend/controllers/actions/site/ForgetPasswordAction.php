<?php

declare(strict_types=1);

namespace backend\controllers\actions\site;

use backend\models\ForgetPasswordForm;
use common\services\TokenServiceInterface;
use Yii;
use yii\base\Action;
use yii\web\Response;

class ForgetPasswordAction extends Action
{
    public function run(TokenServiceInterface $tokenService): string|Response
    {
        $model = new ForgetPasswordForm();

        if (
            $model->load(Yii::$app->request->post())
            && $model->validate()
            && $tokenService->createResetPasswordToken(user: $model->getUser())
        ) {
            Yii::$app->session->setFlash(
                key: 'success',
                value: 'A message with password reset link has been sent to your email',
            );

            return $this->controller->goHome();
        }

        return $this->controller->render(view: 'forget-password', params: ['model' => $model]);
    }
}
