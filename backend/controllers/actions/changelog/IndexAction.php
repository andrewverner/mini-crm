<?php

declare(strict_types=1);

namespace backend\controllers\actions\changelog;

use backend\models\TicketChangelog;
use yii\base\Action;
use yii\data\ActiveDataProvider;

class IndexAction extends Action
{
    public function run(): string
    {
        return $this->controller->render(
            view: 'index',
            params: [
                'dataProvider' => new ActiveDataProvider([
                    'query' => TicketChangelog::find()->orderBy(columns: ['created_at' => SORT_DESC]),
                ]),
            ],
        );
    }
}
