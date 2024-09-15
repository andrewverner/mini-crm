<?php

declare(strict_types=1);

namespace common\services;

use backend\models\TicketChangelog;
use common\models\Ticket;
use Yii;
use yii\db\Exception;
use yii\db\Expression;

class TicketChangelogService implements TicketChangelogServiceInterface
{
    /**
     * @throws Exception
     */
    public function logChanges(array $changedAttributes, Ticket $ticket): void
    {
        $data = [];

        foreach ($changedAttributes as $attribute => $value) {
            $data[$attribute] = [
                'old' => $value,
                'new' => $ticket->{$attribute},
            ];
        }

        $model = new TicketChangelog();
        $model->ticket_id = $ticket->id;
        $model->user_id = Yii::$app->user->id;
        $model->data = json_encode(value: $data);
        $model->created_at = new Expression(expression: 'NOW()');
        $model->save();
    }
}
