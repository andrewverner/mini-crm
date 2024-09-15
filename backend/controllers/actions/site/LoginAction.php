<?php

declare(strict_types=1);

namespace backend\controllers\actions\site;

use backend\models\LoginForm;
use common\services\UserServiceInterface;
use Yii;
use yii\base\Action;
use yii\web\Response;

final class LoginAction extends Action
{
    public function run(UserServiceInterface $userService): string|Response
    {
        if (!Yii::$app->user->isGuest) {
            return $this->controller->goHome();
        }

        $this->controller->layout = 'blank';

        $model = new LoginForm();
        if (
            $model->load(data: Yii::$app->request->post())
            && $model->validate()
            && $userService->authenticateUser(loginForm: $model)
        ) {
            return $this->controller->goHome();
        }

        $model->password = '';

        return $this->controller->render(view: 'login', params: ['model' => $model]);
    }
}
