<?php

declare(strict_types=1);

namespace backend\controllers\actions\ticket;

use common\models\Ticket;
use yii\base\Action;
use yii\web\NotFoundHttpException;

class ViewAction extends Action
{
    /**
     * @throws NotFoundHttpException
     */
    public function run(int $id): string
    {
        $model = Ticket::findOne(condition: $id);

        if ($model === null) {
            throw new NotFoundHttpException(message: 'Ticket not found');
        }

        return $this->controller->render(
            view: 'view',
            params: ['model' => $model],
        );
    }
}
