<?php

declare(strict_types=1);

namespace frontend\controllers\actions\site;

use common\models\Ticket;
use Yii;
use yii\base\Action;
use yii\db\Exception;
use yii\web\Response;

class IndexAction extends Action
{
    /**
     * @throws Exception
     */
    public function run(): string|Response
    {
        $model = new Ticket();

        if (
            $this->controller->request->isPost
            && $model->load(data: $this->controller->request->post())
            && $model->save()
        ) {
            Yii::$app->session->setFlash(
                key: 'success',
                value: 'Thank you for your feedback. Ticket has been created',
            );

            return $this->controller->goHome();
        }

        return $this->controller->render(
            view: 'index',
            params: ['model' => $model],
        );
    }
}
