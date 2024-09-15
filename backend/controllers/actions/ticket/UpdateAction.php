<?php

declare(strict_types=1);

namespace backend\controllers\actions\ticket;

use common\models\Ticket;
use yii\base\Action;
use yii\base\Response;
use yii\db\Exception;
use yii\web\NotFoundHttpException;

class UpdateAction extends Action
{
    /**
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function run(int $id): string|Response
    {
        $model = Ticket::findOne(condition: $id);

        if ($model === null) {
            throw new NotFoundHttpException(message: 'Ticket not found');
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
