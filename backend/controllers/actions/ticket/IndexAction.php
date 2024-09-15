<?php

declare(strict_types=1);

namespace backend\controllers\actions\ticket;

use common\models\TicketSearch;
use yii\base\Action;

class IndexAction extends Action
{
    public function run(): string
    {
        $searchModel = new TicketSearch();
        $dataProvider = $searchModel->search(params: $this->controller->request->queryParams);

        return $this->controller->render(
            view: 'index',
            params: [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ],
        );
    }
}
