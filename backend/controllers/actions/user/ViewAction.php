<?php

declare(strict_types=1);

namespace backend\controllers\actions\user;

use common\models\User;
use yii\base\Action;
use yii\web\NotFoundHttpException;

class ViewAction extends Action
{
    /**
     * @throws NotFoundHttpException
     */
    public function run(string $id): string
    {
        $model = User::findOne(condition: $id);

        if ($model === null) {
            throw new NotFoundHttpException(message: 'User not found');
        }

        return $this->controller->render(
            view: 'view',
            params: ['model' => $model],
        );
    }
}
