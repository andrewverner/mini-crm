<?php

declare(strict_types=1);

namespace backend\controllers\actions\user;

use common\models\User;
use yii\base\Action;
use yii\db\Exception;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class UpdateAction extends Action
{
    /**
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function run(string $id): string|Response
    {
        $model = User::findOne(condition: $id);

        if ($model === null) {
            throw new NotFoundHttpException(message: 'User not found');
        }

        if (
            $this->controller->request->isPost
            && $model->load($this->controller->request->post())
            && $model->save()
        ) {
            return $this->controller->redirect(['view', 'id' => $model->id]);
        }

        return $this->controller->render(
            view: 'update',
            params: ['model' => $model],
        );
    }
}
