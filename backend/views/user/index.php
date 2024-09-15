<?php

use backend\components\columns\RolesColumn;
use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var common\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Users';
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
            'email:email',
            [
                'header' => 'Status',
                'content' => static fn (User $user)
                    => ucfirst(string: User::STATUS_MAP[$user->getStatusCode()]),
            ],
            ['class' => RolesColumn::class],
            'deleted_at:datetime',
            [
                'class' => ActionColumn::class,
                'urlCreator' => static fn ($action, User $model, $key, $index, $column) =>
                    Url::toRoute([$action, 'id' => $model->id]),
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
