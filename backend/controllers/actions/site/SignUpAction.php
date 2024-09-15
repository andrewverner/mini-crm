<?php

declare(strict_types=1);

namespace backend\controllers\actions\site;

use backend\models\SignUpForm;
use common\services\UserServiceInterface;
use Yii;
use yii\base\Action;
use yii\web\Response;

final class SignUpAction extends Action
{
    public function run(UserServiceInterface $userService): string|Response
    {
        $this->controller->layout = 'blank';

        $model = new SignUpForm();

        if (
            $model->load(data: Yii::$app->request->post())
            && $model->validate()
            && $userService->createUser(signUpForm: $model)
        ) {
            Yii::$app->session->setFlash(
                key: 'success',
                value: 'A message with an activation link has been sent to your email',
            );

            return $this->controller->goHome();
        }

        return $this->controller->render(view: 'sign-up', params: ['model' => $model]);
    }
}
