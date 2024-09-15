<?php

use backend\components\columns\TicketChangelogDataColumn;
use backend\models\TicketChangelog;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => yii\grid\SerialColumn::class],
            [
                'header' => 'User',
                'attribute' => 'user.email',
            ],
            'created_at:datetime',
            [
                'header' => 'Ticket',
                'attribute' => 'ticket.title',
            ],
            ['class' => TicketChangelogDataColumn::class],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
