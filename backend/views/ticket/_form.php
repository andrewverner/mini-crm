<?php

use common\models\Ticket;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Ticket $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="ticket-form">
    <div class="row">
        <div class="col-lg-4">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field(model: $model, attribute: 'name')->textInput() ?>

            <?= $form->field(model: $model, attribute: 'title')->textInput() ?>

            <?= $form->field(model: $model, attribute: 'item')->dropDownList(
                items: [
                    'Apples' => 'Apples',
                    'Oranges' => 'Oranges',
                    'Tangerines' => 'Tangerines',
                ]
            ) ?>

            <?= $form->field(model: $model, attribute: 'phone')->textInput() ?>

            <?= $form->field(model: $model, attribute: 'status')->dropDownList(items: Ticket::STATUS_MAP) ?>

            <?= $form->field(model: $model, attribute: 'price')->textInput() ?>

            <div class="form-group">
                <?= Html::submitButton(content: 'Save', options: ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>