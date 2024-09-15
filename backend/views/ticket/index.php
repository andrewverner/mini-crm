<?php

use common\models\Ticket;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var common\models\TicketSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Tickets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => yii\grid\SerialColumn::class],
            'name',
            'title',
            'item',
            'phone',
            'created_at:datetime',
            [
                'header' => 'Status',
                'value' => static fn (Ticket $ticket) => Ticket::STATUS_MAP[$ticket->status],
            ],
            'comment',
            'price',
            [
                'class' => ActionColumn::class,
                'template' => '{view} {update}',
                'urlCreator' => static fn ($action, Ticket $model, $key, $index, $column) =>
                    Url::toRoute([$action, 'id' => $model->id]),
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
