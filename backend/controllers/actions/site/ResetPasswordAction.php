<?php

declare(strict_types=1);

namespace backend\controllers\actions\site;

use backend\models\ResetPasswordForm;
use common\repositories\TokenRepositoryInterface;
use common\services\TokenServiceInterface;
use Yii;
use yii\base\Action;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ResetPasswordAction extends Action
{
    /**
     * @throws NotFoundHttpException
     */
    public function run(
        string $hash,
        TokenServiceInterface $tokenService,
        TokenRepositoryInterface $tokenRepository,
    ): string|Response {
        if ($tokenRepository->findValidToken(hash: $hash) === null) {
            throw new NotFoundHttpException(message: 'Page not found', code: 404);
        }

        $model = new ResetPasswordForm();
        $model->hash = $hash;

        if (
            $model->load(Yii::$app->request->post())
            && $model->validate()
            && $tokenService->resetPassword(resetPasswordForm: $model)
        ) {
            Yii::$app->session->setFlash(
                key: 'success',
                value: 'Your password has been changed',
            );

            return $this->controller->redirect(url: '/login');
        }

        return $this->controller->render(view: 'reset-password', params: ['model' => $model]);
    }
}
