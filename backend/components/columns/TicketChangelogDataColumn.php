<?php

declare(strict_types=1);

namespace backend\components\columns;

use backend\models\TicketChangelog;
use Yii;
use yii\grid\DataColumn;

class TicketChangelogDataColumn extends DataColumn
{
    public $header = 'Data';

    public function renderDataCellContent($model, $key, $index): ?string
    {
        if (!$model instanceof TicketChangelog) {
            return null;
        }

        $data = json_decode(json: $model->data, associative: true);

        return Yii::$app->controller->renderFile(
            file: Yii::getAlias(alias: '@backend/components/columns/views/ticket-changelog-data.php'),
            params: ['data' => $data],
        );
    }
}
