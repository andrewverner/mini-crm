<?php

declare(strict_types=1);

namespace backend\controllers\actions\ticket;

use common\models\Ticket;
use yii\base\Action;
use yii\db\Query;

class DownloadAction extends Action
{
    public function run()
    {
        $query = (new Query())->from(tables: Ticket::tableName());
        $filename = time() . '.csv';

        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        /** @var array<Ticket> $tickets */
        foreach ($query->batch(batchSize: 1000) as $tickets) {
            foreach ($tickets as $ticket) {
                echo sprintf(
                    '%s;%s;%f;%d',
                    $ticket["title"],
                    $ticket["item"],
                    $ticket["price"],
                    $ticket["phone"],
                ) . PHP_EOL;
            }
        }

        exit();
    }
}
